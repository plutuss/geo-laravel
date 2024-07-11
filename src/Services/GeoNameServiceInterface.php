<?php

namespace Plutuss\GeoNames\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface GeoNameServiceInterface
{

    /**
     * @param string $countryCode
     * @return $this
     */
    public function setCountryCode(string $countryCode): static;

    /**
     * @param int $value
     * @return $this
     */
    public function setPostalCode(int $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setPostalCodeStartsWith(string $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setPlaceName(string $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setPlaceNameStartsWith(string $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setCountry(string $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setCountryBias(string $value): static;

    /**
     * @param int $value
     * @return $this
     */
    public function setMaxRows(int $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setStyle(string $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setOperator(string $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setCharset(string $value): static;

    /**
     * @param bool $value
     * @return $this
     */
    public function setIsReduced(bool $value): static;

    /**
     * @param float $value
     * @return $this
     */
    public function setEast(float $value): static;

    /**
     * @param float $value
     * @return $this
     */
    public function setWest(float $value): static;

    /**
     * @param float $value
     * @return $this
     */
    public function setNorth(float $value): static;

    /**
     * @param float $value
     * @return $this
     */
    public function setSouth(float $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setLatitude(string $value): static;

    /**
     * @param string $value
     * @return $this
     */
    public function setLongitude(string $value): static;

    /**
     * @param int $value
     * @return $this
     */
    public function setRadius(int $value): static;

    /**
     * @param string $country
     * @return JsonResponse|array|Collection
     */
    public function searchJSON(string $country): JsonResponse|array|Collection;


    /**
     * @param int $postalCode
     * @param int $radius
     * @param int $maxRows
     * @return JsonResponse|array|Collection
     */
    public function postalCodeSearchJSONFromPostCode(int $postalCode, int $radius = 5, int $maxRows = 10): JsonResponse|array|Collection;


    /**
     * @param string $name
     * @param int $radius
     * @param int $maxRows
     * @return JsonResponse|array|Collection
     */
    public function postalCodeSearchJSONFromName(string $name, int $radius = 5, int $maxRows = 10): JsonResponse|array|Collection;

    /**
     * @param int $lat
     * @param int $lng
     * @return JsonResponse|array|Collection
     */
    public function findNearbyPostalCodes(int $lat, int $lng): JsonResponse|array|Collection;

    /**
     * @return JsonResponse|array|Collection
     */
    public function postalCodeCountryInfo(): JsonResponse|array|Collection;

    /**
     * @param int $lat
     * @param int $lng
     * @return JsonResponse|array|Collection
     */
    public function findNearbyJSON(int $lat, int $lng): JsonResponse|array|Collection;

    /**
     * @param array $params
     * @return $this
     */
    public function setOption(array $params): static;

    /**
     * @param string $key
     * @return bool
     */
    public function hasParam(string $key): bool;

    /**
     * @return array
     */
    public function getParams(): array;

}
