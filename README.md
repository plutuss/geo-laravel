# Laravel GeoNames API

[![Packagist version](https://img.shields.io/packagist/v/plutuss/laravel-geonames-api)](https://packagist.org/packages/plutuss/laravel-geonames-api)
[![Packagist downloads](https://img.shields.io/packagist/dt/plutuss/laravel-geonames-api)](https://packagist.org/packages/plutuss/laravel-geonames-api)
[![MIT license](https://img.shields.io/packagist/l/plutuss/laravel-geonames-api)](./LICENSE.md)

Look up postal codes, find places near coordinates, and resolve local time zones in Laravel. Use the GeoNames API to add city suggestions to address forms or display local times on location-based pages.

## Installation

Requires Laravel 8–11 and PHP 8.0 or newer, subject to your Laravel version's PHP requirements.

```bash
composer require plutuss/laravel-geonames-api
```

Create a GeoNames account, enable web services for it, and add the username to your Laravel application's `.env`. [GeoNames web services setup](https://www.geonames.org/export/web-services.html)

```dotenv
GEO_NAMES_USERNAME=your_geonames_username
```

The examples below describe the current repository code. Check the changelog on GitHub and the version on Packagist when using a tagged release. [GitHub releases](https://github.com/plutuss/geo-laravel/releases) · [Packagist versions](https://packagist.org/packages/plutuss/laravel-geonames-api)

## Quick start

```php
use Plutuss\GeoNames\Facades\GeoName;

$places = GeoName::setCountryCode('DE')
    ->postalCodeSearchJSONFromPostCode('01067');

$city = $places->first()?->placeName();
```

Pass postal codes as strings to preserve leading zeros and letters. The default response is a Laravel collection of `GeoNameResponse` objects.

### Find nearby places and local time

```php
use Plutuss\GeoNames\Facades\GeoName;

$nearby = GeoName::setMaxRows(5)
    ->findNearbyPlaceNameJSON(51.0504, 13.7373);

$timezone = GeoName::timezoneJSON(51.0504, 13.7373)
    ->first()?->getNestedValue('timezoneId');
```

### Search by place name

```php
use Plutuss\GeoNames\Facades\GeoName;

$places = GeoName::setOption(['q' => 'Dresden', 'maxRows' => 5])
    ->searchJSON('DE');
```

## API reference

| Method | Result |
| --- | --- |
| `searchJSON($country = null)` | Place search. Pass search parameters such as `q` through `setOption()`. |
| `postalCodeSearchJSONFromPostCode($postalCode, $radius = null, $maxRows = null)` | Postal records matching a code. |
| `postalCodeSearchJSONFromName($name, $radius = null, $maxRows = null)` | Postal records matching a place-name prefix. |
| `postalCodeLookupJSON($postalCode, $country = null)` | Places matching a postal code. |
| `findNearbyPostalCodes($lat, $lng)` | Postal records near a point. |
| `postalCodeCountryInfo()` | Countries with postal-code geocoding data. |
| `findNearbyJSON($lat, $lng)` | Geographic features near a point. |
| `findNearbyPlaceNameJSON($lat, $lng)` | Populated places near a point. |
| `getCountryCodeFromCoordinates($lat, $lng)` | Country code and details for a point. |
| `countryInfoJSON($country = null)` | Country details such as capital and population. Omit the country to list all countries. |
| `timezoneJSON($lat, $lng)` | Time zone and local time for a point. |
| `getByGeoNameId($geoNameId)` | A geographic feature by its GeoNames ID. |

Country filters accept ISO 3166-1 alpha-2 codes such as `DE`. Coordinates accept decimal degrees. Postal searches default to a radius of 5 and a maximum of 10 rows. Options set through `setOption()` or fluent setters apply to the next call, even if it fails. Method arguments take precedence over fluent options, followed by configuration defaults. See the [service interface](src/Services/GeoNameServiceInterface.php) for available setters and the [GeoNames documentation](https://www.geonames.org/export/web-services.html) for endpoint-specific options.

Use `Plutuss\GeoNames\Services\GeoNameServiceInterface` for dependency injection.

## Configuration

Laravel loads the default settings automatically. Publish the configuration to customize options such as the default country or response adapters.

```bash
php artisan vendor:publish --provider="Plutuss\GeoNames\Providers\GeoNamesServiceProvider"
```

| Setting | Default | Purpose |
| --- | --- | --- |
| `GEO_NAMES_USERNAME` | Empty | Username for a GeoNames account with web services enabled. |
| `GEO_NAMES_ENDPOINT` | `https://secure.geonames.org` | Base URL for GeoNames API requests. |
| `GEO_NAMES_RESPONSE` | `collection` | Response format. Supports `collection`, `array`, and `json`. |
| `geo-names.country-code` | Empty | Default country for place search, postal search, and postal lookup. |

### Response formats

| Format | Return value |
| --- | --- |
| `collection` | Laravel collection of `GeoNameResponse` objects. |
| `array` | Array of records. Set `geo-names.type_response.arrays_with_wrapper` to `true` for an array of `GeoNameResponse` objects. |
| `json` | Laravel `JsonResponse` with the records under the `data` key. |

Time-zone, country-code, and GeoNames ID lookups return a single record inside the configured response format. Searches with no matches return an empty list in that format. In collection mode, access postal fields with `placeName()`, `postalCode()`, or `countryCode()`. Use `getArrayData()` for the raw record or `getNestedValue()` for other fields.

### Error handling

Laravel's HTTP client throws `Illuminate\Http\Client\RequestException` for HTTP errors and `Illuminate\Http\Client\ConnectionException` for connection failures. GeoNames API errors and invalid responses throw `UnexpectedValueException`. For a GeoNames API error, the exception carries the upstream error code when available. [GeoNames error codes](https://www.geonames.org/export/webservice-exception.html)

## Development

```bash
composer install
composer test
```

Tests use Laravel HTTP fakes and run without a GeoNames account. Report bugs with the package version, Laravel version, and a small reproduction. [GitHub Issues](https://github.com/plutuss/geo-laravel/issues)

## License and data attribution

The package is released under the [MIT license](./LICENSE.md). Geographic data comes from GeoNames. Include GeoNames attribution wherever your application uses that data. [GeoNames data and web services](https://www.geonames.org/export/)
