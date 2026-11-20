<?php

declare(strict_types=1);

namespace Plutuss\GeoNames\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Plutuss\GeoNames\Facades\GeoName;
use Plutuss\GeoNames\Providers\GeoNamesServiceProvider;
use Plutuss\GeoNames\Response\GeoNameResponse;
use UnexpectedValueException;

final class GeoNameTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [GeoNamesServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set([
            'geo-names.username' => 'test-user',
            'geo-names.endpoint' => 'https://geonames.test/',
            'geo-names.country-code' => 'DE',
            'geo-names.type_response.default' => 'array',
        ]);
    }

    public function testPostalSearchOptionsApplyOnlyToTheNextRequest(): void
    {
        Http::fake(['*' => Http::response(['postalCodes' => []])]);

        self::assertSame([], GeoName::setCountryCode('CH')
            ->setMaxRows(3)
            ->postalCodeSearchJSONFromPostCode('01067'));
        self::assertSame([], GeoName::postalCodeSearchJSONFromName('Dresden'));

        $requests = Http::recorded();
        self::assertCount(2, $requests);
        $this->assertRequest($requests[0][0], 'postalCodeSearchJSON', [
            'country' => 'CH', 'postalcode' => '01067', 'radius' => '5', 'maxRows' => '3',
        ]);
        $this->assertRequest($requests[1][0], 'postalCodeSearchJSON', [
            'country' => 'DE', 'placename_startsWith' => 'Dresden', 'radius' => '5', 'maxRows' => '10',
        ]);
    }

    public function testExplicitCountryTakesPrecedenceOverFluentAndConfiguredCountry(): void
    {
        Http::fake(['*' => Http::response(['geonames' => []])]);

        GeoName::setCountryCode('AT')->searchJSON(' CH ');

        $this->assertOnlyRequest('searchJSON', ['country' => 'CH']);
    }

    public function testGeoNamesErrorPreservesTheCodeAndDiscardsRequestOptions(): void
    {
        Http::fakeSequence()
            ->push(['status' => ['value' => 18, 'message' => 'daily limit exceeded']])
            ->push(['geonames' => []]);

        try {
            GeoName::setCountryCode('CH')->searchJSON();
            self::fail('Expected a GeoNames exception.');
        } catch (UnexpectedValueException $exception) {
            self::assertSame(18, $exception->getCode());
            self::assertStringContainsString('daily limit exceeded', $exception->getMessage());
        }

        self::assertSame([], GeoName::getParams());
        self::assertSame([], GeoName::searchJSON());
        $this->assertRequest(Http::recorded()[1][0], 'searchJSON', ['country' => 'DE']);
    }

    public function testHttpErrorIsPropagatedAndDiscardsRequestOptions(): void
    {
        Http::fake(['*' => Http::response('Unavailable', 503)]);

        try {
            GeoName::setCountryCode('CH')->searchJSON();
            self::fail('Expected an HTTP exception.');
        } catch (RequestException $exception) {
            self::assertSame(503, $exception->response->status());
        }

        self::assertSame([], GeoName::getParams());
    }

    /** @dataProvider malformedResponses */
    #[DataProvider('malformedResponses')]
    public function testMalformedResponseIsRejected(mixed $payload): void
    {
        Http::fake(['*' => Http::response($payload)]);

        $this->expectException(UnexpectedValueException::class);
        GeoName::searchJSON();
    }

    public static function malformedResponses(): array
    {
        return [
            'invalid JSON' => ['not JSON'],
            'missing result list' => [['unexpected' => []]],
            'invalid record' => [['geonames' => [null]]],
        ];
    }

    /** @dataProvider lookupResponses */
    #[DataProvider('lookupResponses')]
    public function testLookupEndpoints(
        string $method,
        array $arguments,
        string $endpoint,
        array $query,
        array $payload,
        array $expected
    ): void {
        Http::fake(['*' => Http::response($payload)]);

        self::assertSame($expected, GeoName::$method(...$arguments));
        $this->assertOnlyRequest($endpoint, $query);
    }

    public static function lookupResponses(): array
    {
        $coordinates = ['lat' => '51.0504', 'lng' => '13.7373'];
        $dresden = ['name' => 'Dresden', 'geonameId' => 2935022];
        $germany = ['countryCode' => 'DE', 'countryName' => 'Germany'];
        $timezone = ['timezoneId' => 'Europe/Berlin'];
        $postalPlace = ['postalCode' => '01067', 'placeName' => 'Dresden'];

        return [
            'time zone' => [
                'timezoneJSON', [51.0504, 13.7373], 'timezoneJSON', $coordinates, $timezone, [$timezone],
            ],
            'all countries' => ['countryInfoJSON', [], 'countryInfoJSON', [], ['geonames' => [$germany]], [$germany]],
            'one country' => [
                'countryInfoJSON', ['DE'], 'countryInfoJSON', ['country' => 'DE'],
                ['geonames' => [$germany]], [$germany],
            ],
            'nearby populated place' => [
                'findNearbyPlaceNameJSON', [51.0504, 13.7373], 'findNearbyPlaceNameJSON', $coordinates,
                ['geonames' => [$dresden]], [$dresden],
            ],
            'GeoNames ID' => [
                'getByGeoNameId', [2935022], 'getJSON', ['geonameId' => '2935022'], $dresden, [$dresden],
            ],
            'postal code lookup' => [
                'postalCodeLookupJSON', ['01067', 'DE'], 'postalCodeLookupJSON',
                ['postalcode' => '01067', 'country' => 'DE'], ['postalcodes' => [$postalPlace]], [$postalPlace],
            ],
            'nearby postal codes' => [
                'findNearbyPostalCodes', [51.0504, 13.7373], 'findNearbyPostalCodesJSON', $coordinates,
                ['postalCodes' => [$postalPlace]], [$postalPlace],
            ],
            'country code' => [
                'getCountryCodeFromCoordinates', [51.0504, 13.7373], 'countryCodeJSON', $coordinates, $germany, [$germany],
            ],
            'postal code country info' => [
                'postalCodeCountryInfo', [], 'postalCodeCountryInfoJSON', [], ['geonames' => [$germany]], [$germany],
            ],
        ];
    }

    public function testCollectionAndJsonResponseFormatsUseTheSameRecords(): void
    {
        $record = ['timezoneId' => 'Europe/Berlin'];
        Http::fake(['*' => Http::response($record)]);

        $this->app['config']->set('geo-names.type_response.default', 'collection');
        $collection = GeoName::timezoneJSON(51.0504, 13.7373);
        self::assertCount(1, $collection);
        self::assertInstanceOf(GeoNameResponse::class, $collection->first());
        self::assertSame($record, $collection->first()->getArrayData());

        $this->app['config']->set('geo-names.type_response.default', 'json');
        self::assertSame(['data' => [$record]], GeoName::timezoneJSON(51.0504, 13.7373)->getData(true));
    }

    private function assertOnlyRequest(string $endpoint, array $expectedQuery): void
    {
        $requests = Http::recorded();
        self::assertCount(1, $requests);
        $this->assertRequest($requests[0][0], $endpoint, $expectedQuery);
    }

    private function assertRequest(Request $request, string $endpoint, array $expectedQuery): void
    {
        self::assertSame('GET', $request->method());
        [$url, $query] = explode('?', $request->url(), 2);
        self::assertSame('https://geonames.test/' . $endpoint, $url);
        parse_str($query, $actual);
        $expectedQuery['username'] = 'test-user';
        ksort($actual);
        ksort($expectedQuery);
        self::assertSame($expectedQuery, $actual);
    }
}
