<?php

namespace Plutuss\GeoNames\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\GeoNames\Response\AdapterResponse;
use Plutuss\GeoNames\Traits\HasParameter;
use UnexpectedValueException;

class GeoNameService implements GeoNameServiceInterface
{
    use HasParameter;

    public function __construct(protected GeoNameClientService $clientService)
    {
    }

    public function searchJSON(?string $country = null): JsonResponse|array|Collection
    {
        $country = trim($country ?? '');
        $params = $country === '' ? [] : ['country' => $country];

        return $this->request('searchJSON', 'geonames', $params, $this->countryDefaults());
    }

    public function postalCodeSearchJSONFromPostCode(
        string|int $postalCode,
        ?int $radius = null,
        ?int $maxRows = null
    ): JsonResponse|array|Collection {
        return $this->searchPostalCodes(['postalcode' => (string) $postalCode], $radius, $maxRows);
    }

    public function postalCodeSearchJSONFromName(
        string $name,
        ?int $radius = null,
        ?int $maxRows = null
    ): JsonResponse|array|Collection {
        return $this->searchPostalCodes(['placename_startsWith' => $name], $radius, $maxRows);
    }

    public function findNearbyPostalCodes(float $lat, float $lng): JsonResponse|array|Collection
    {
        return $this->request('findNearbyPostalCodesJSON', 'postalCodes', ['lat' => $lat, 'lng' => $lng]);
    }

    public function getCountryCodeFromCoordinates(float $lat, float $lng): JsonResponse|array|Collection
    {
        return $this->requestRecord('countryCodeJSON', 'countryCode', ['lat' => $lat, 'lng' => $lng]);
    }

    public function postalCodeCountryInfo(): JsonResponse|array|Collection
    {
        return $this->request('postalCodeCountryInfoJSON', 'geonames');
    }

    public function findNearbyJSON(float $lat, float $lng): JsonResponse|array|Collection
    {
        return $this->request('findNearbyJSON', 'geonames', ['lat' => $lat, 'lng' => $lng]);
    }

    public function timezoneJSON(float $lat, float $lng): JsonResponse|array|Collection
    {
        return $this->requestRecord('timezoneJSON', 'timezoneId', ['lat' => $lat, 'lng' => $lng]);
    }

    public function countryInfoJSON(?string $country = null): JsonResponse|array|Collection
    {
        $country = trim($country ?? '');
        $params = $country === '' ? [] : ['country' => $country];

        return $this->request('countryInfoJSON', 'geonames', $params);
    }

    public function findNearbyPlaceNameJSON(float $lat, float $lng): JsonResponse|array|Collection
    {
        return $this->request('findNearbyPlaceNameJSON', 'geonames', ['lat' => $lat, 'lng' => $lng]);
    }

    public function getByGeoNameId(int $geoNameId): JsonResponse|array|Collection
    {
        return $this->requestRecord('getJSON', 'geonameId', ['geonameId' => $geoNameId]);
    }

    public function postalCodeLookupJSON(string|int $postalCode, ?string $country = null): JsonResponse|array|Collection
    {
        $params = ['postalcode' => (string) $postalCode];
        $country = trim($country ?? '');
        if ($country !== '') {
            $params['country'] = $country;
        }

        return $this->request('postalCodeLookupJSON', 'postalcodes', $params, $this->countryDefaults());
    }

    private function searchPostalCodes(array $params, ?int $radius, ?int $maxRows): JsonResponse|array|Collection
    {
        $params += array_filter(['radius' => $radius, 'maxRows' => $maxRows], static fn ($value) => $value !== null);

        return $this->request(
            'postalCodeSearchJSON',
            'postalCodes',
            $params,
            $this->countryDefaults() + ['radius' => 5, 'maxRows' => 10]
        );
    }

    private function countryDefaults(): array
    {
        $country = trim((string) config('geo-names.country-code'));

        return $country === '' ? [] : ['country' => $country];
    }

    private function request(
        string $method,
        string $resultKey,
        array $params = [],
        array $defaults = []
    ): JsonResponse|array|Collection {
        $data = $this->fetch($method, $params, $defaults);
        $records = $data[$resultKey] ?? null;
        if (!is_array($records) || array_values($records) !== $records) {
            throw new UnexpectedValueException("GeoNames returned an invalid $resultKey list for $method.");
        }

        foreach ($records as $record) {
            if (!is_array($record)) {
                throw new UnexpectedValueException("GeoNames returned an invalid record in $resultKey for $method.");
            }
        }

        return (new AdapterResponse())->getResponse($records);
    }

    private function requestRecord(string $method, string $requiredKey, array $params): JsonResponse|array|Collection
    {
        $data = $this->fetch($method, $params);
        if (!is_string($data[$requiredKey] ?? null) && !is_int($data[$requiredKey] ?? null)) {
            throw new UnexpectedValueException("GeoNames returned no valid $requiredKey for $method.");
        }

        return (new AdapterResponse())->getResponse([$data]);
    }

    private function fetch(string $method, array $params, array $defaults = []): array
    {
        $params += $this->params + $defaults;
        $this->params = [];

        return $this->clientService->getJson($method, $params);
    }
}
