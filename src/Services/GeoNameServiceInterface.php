<?php

namespace Plutuss\GeoNames\Services;

interface GeoNameServiceInterface
{

    // HasParameter
    public function setCountryCode(string $countryCode): static;

    public function setPostalCode(string $value): static;

    public function setPostalCodeStartsWith(string $value): static;

    public function setPlaceName(string $value): static;

    public function setPlaceNameStartsWith(string $value): static;

    public function setCountry(string $value): static;

    public function setCountryBias(string $value): static;

    public function setMaxRows(int $value): static;

    public function setStyle(string $value): static;

    public function setOperator(string $value): static;

    public function setCharset(string $value): static;

    public function setIsReduced(bool $value): static;

    public function setEast(float $value): static;

    public function setWest(float $value): static;

    public function setNorth(float $value): static;

    public function setSouth(float $value): static;

    public function setLatitude(string $value): static;

    public function setLongitude(string $value): static;

    // end HasParameter


    public function getCities();

    public function getCitiesFromPostCode(int $postalCode, int $radius = 5, int $maxRows = 10);

    public function getCitiFromName(string $name, int $radius = 5, int $maxRows = 10);

    public function findNearbyPostalCodes(int $lat, int $lng);

    public function postalCodeCountryInfo();

    public function findNearbyJSON(int $lat, int $lng);

}
