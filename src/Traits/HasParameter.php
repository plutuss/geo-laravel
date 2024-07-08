<?php

namespace Plutuss\GeoNames\Traits;

trait HasParameter
{

    public function setCountryCode(string $value): static
    {
        $this->clientService->setParams('country', $value);

        return $this;
    }

    public function setPostalCode(string $value): static
    {
        $this->clientService->setParams('postalcode', $value);

        return $this;
    }

    public function setPostalCodeStartsWith(string $value): static
    {
        $this->clientService->setParams('postalcode_startsWith', $value);

        return $this;
    }

    public function setPlaceName(string $value): static
    {
        $this->clientService->setParams('placename', $value);

        return $this;
    }

    public function setPlaceNameStartsWith(string $value): static
    {
        $this->clientService->setParams('placename_startsWith', $value);

        return $this;
    }

    public function setCountry(string $value): static
    {
        $this->clientService->setParams('country', trim($value));

        return $this;
    }


    public function setCountryBias(string $value): static
    {
        $this->clientService->setParams('countryBias', $value);

        return $this;
    }

    public function setMaxRows(int $value): static
    {
        $this->clientService->setParams('maxRows', $value);

        return $this;
    }

    public function setStyle(string $value): static
    {

        $validSizes = ['SHORT', 'MEDIUM', 'LONG', 'FULL'];
        if (!in_array($value, $validSizes)) {
            throw new \InvalidArgumentException("Invalid size value");
        }

        $this->clientService->setParams('style', $value);

        return $this;
    }

    public function setOperator(string $value): static
    {

        $validSizes = ['AND', 'OR'];
        if (!in_array($value, $validSizes)) {
            throw new \InvalidArgumentException("Invalid operator value");
        }

        $this->clientService->setParams('operator', $value);

        return $this;
    }

    public function setCharset(string $value): static
    {
        $this->clientService->setParams('charset', $value);

        return $this;
    }

    public function setIsReduced(bool $value): static
    {
        $this->clientService->setParams('isReduced', $value);

        return $this;
    }

    public function setEast(float $value): static
    {
        $this->clientService->setParams('east', $value);

        return $this;
    }

    public function setWest(float $value): static
    {
        $this->clientService->setParams('west', $value);

        return $this;
    }

    public function setNorth(float $value): static
    {
        $this->clientService->setParams('north', $value);

        return $this;
    }

    public function setSouth(float $value): static
    {
        $this->clientService->setParams('south', $value);

        return $this;
    }


    public function setLatitude(string $value): static
    {
        $this->clientService->setParams('lat', $value);
        return $this;
    }

    public function setLongitude(string $value): static
    {
        $this->clientService->setParams('lng', $value);
        return $this;
    }

    public function setRadius(int $value): static
    {
        $this->clientService->setParams('radius', $value);
        return $this;
    }

}
