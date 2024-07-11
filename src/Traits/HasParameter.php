<?php

namespace Plutuss\GeoNames\Traits;

trait HasParameter
{

    /**
     * @param string $value
     * @return $this
     */
    public function setCountryCode(string $value): static
    {
        $this->clientService->setParams('country', $value);

        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setPostalCode(int $value): static
    {
        $this->clientService->setParams('postalcode', $value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPostalCodeStartsWith(string $value): static
    {
        $this->clientService->setParams('postalcode_startsWith', $value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPlaceName(string $value): static
    {
        $this->clientService->setParams('placename', $value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPlaceNameStartsWith(string $value): static
    {
        $this->clientService->setParams('placename_startsWith', $value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCountry(string $value): static
    {
        $this->clientService->setParams('country', trim($value));

        return $this;
    }


    /**
     * @param string $value
     * @return $this
     */
    public function setCountryBias(string $value): static
    {
        $this->clientService->setParams('countryBias', $value);

        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setMaxRows(int $value): static
    {
        $this->clientService->setParams('maxRows', $value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setStyle(string $value): static
    {

        $validSizes = ['SHORT', 'MEDIUM', 'LONG', 'FULL'];

        if (!in_array($value, $validSizes)) {
            throw new \InvalidArgumentException("Invalid size value");
        }

        $this->clientService->setParams('style', $value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOperator(string $value): static
    {

        $validSizes = ['AND', 'OR'];

        if (!in_array($value, $validSizes)) {
            throw new \InvalidArgumentException("Invalid operator value");
        }

        $this->clientService->setParams('operator', $value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCharset(string $value): static
    {
        $this->clientService->setParams('charset', $value);

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setIsReduced(bool $value): static
    {
        $this->clientService->setParams('isReduced', $value);

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setEast(float $value): static
    {
        $this->clientService->setParams('east', $value);

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setWest(float $value): static
    {
        $this->clientService->setParams('west', $value);

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setNorth(float $value): static
    {
        $this->clientService->setParams('north', $value);

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setSouth(float $value): static
    {
        $this->clientService->setParams('south', $value);

        return $this;
    }


    /**
     * @param string $value
     * @return $this
     */
    public function setLatitude(string $value): static
    {
        $this->clientService->setParams('lat', $value);
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setLongitude(string $value): static
    {
        $this->clientService->setParams('lng', $value);
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setRadius(int $value): static
    {
        $this->clientService->setParams('radius', $value);
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setOption(array $params): static
    {
        $this->clientService->setOption($params);
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParam(string $key): bool
    {
        return $this->clientService->hasParam($key);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->clientService->getParams();
    }

}
