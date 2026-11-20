<?php

namespace Plutuss\GeoNames\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Plutuss\GeoNames\Services\GeoNameServiceInterface;


/**
 * @method static GeoNameServiceInterface setCountryCode(string $countryCode)
 * @method static GeoNameServiceInterface setPostalCode(string|int $value)
 * @method static GeoNameServiceInterface setPostalCodeStartsWith(string $value)
 * @method static GeoNameServiceInterface setPlaceName(string $value)
 * @method static GeoNameServiceInterface setPlaceNameStartsWith(string $value)
 * @method static GeoNameServiceInterface setCountry(string $value)
 * @method static GeoNameServiceInterface setCountryBias(string $value)
 * @method static GeoNameServiceInterface setMaxRows(int $value)
 * @method static GeoNameServiceInterface setRadius(int $value)
 * @method static GeoNameServiceInterface setStyle(string $value)
 * @method static GeoNameServiceInterface setOperator(string $value)
 * @method static GeoNameServiceInterface setCharset(string $value)
 * @method static GeoNameServiceInterface setIsReduced(bool $value)
 * @method static GeoNameServiceInterface setEast(float $value)
 * @method static GeoNameServiceInterface setWest(float $value)
 * @method static GeoNameServiceInterface setNorth(float $value)
 * @method static GeoNameServiceInterface setSouth(float $value)
 * @method static GeoNameServiceInterface setLatitude(string $value)
 * @method static GeoNameServiceInterface setLongitude(string $value)
 * @method static GeoNameServiceInterface setOption(array $params)
 * @method static bool hasParam(string $key)
 * @method static array getParams()
 * @method static JsonResponse|array|Collection searchJSON(?string $country = null)
 * @method static JsonResponse|array|Collection getCountryCodeFromCoordinates(float $lat, float $lng)
 * @method static JsonResponse|array|Collection postalCodeSearchJSONFromPostCode(string|int $postalCode, ?int $radius = null, ?int $maxRows = null)
 * @method static JsonResponse|array|Collection postalCodeSearchJSONFromName(string $name, ?int $radius = null, ?int $maxRows = null)
 * @method static JsonResponse|array|Collection findNearbyPostalCodes(float $lat, float $lng)
 * @method static JsonResponse|array|Collection postalCodeCountryInfo()
 * @method static JsonResponse|array|Collection findNearbyJSON(float $lat, float $lng)
 * @method static JsonResponse|array|Collection timezoneJSON(float $lat, float $lng)
 * @method static JsonResponse|array|Collection countryInfoJSON(?string $country = null)
 * @method static JsonResponse|array|Collection findNearbyPlaceNameJSON(float $lat, float $lng)
 * @method static JsonResponse|array|Collection getByGeoNameId(int $geoNameId)
 * @method static JsonResponse|array|Collection postalCodeLookupJSON(string|int $postalCode, ?string $country = null)
 *
 *
 * @see \Plutuss\GeoNames\Services\GeoNameService
 */
class GeoName extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'geo.name.app';
    }

}
