<?php

namespace Plutuss\GeoNames\Traits;

trait HasParameter
{
    private array $params = [];

    /**
     * @param string $value
     * @return $this
     */
    public function setCountryCode(string $value): static
    {
        $this->params['country'] = $value;

        return $this;
    }

    /**
     * @param string|int $value
     * @return $this
     */
    public function setPostalCode(string|int $value): static
    {
        $this->params['postalcode'] = (string) $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPostalCodeStartsWith(string $value): static
    {
        $this->params['postalcode_startsWith'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPlaceName(string $value): static
    {
        $this->params['placename'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPlaceNameStartsWith(string $value): static
    {
        $this->params['placename_startsWith'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCountry(string $value): static
    {
        $this->params['country'] = trim($value);

        return $this;
    }


    /**
     * @param string $value
     * @return $this
     */
    public function setCountryBias(string $value): static
    {
        $this->params['countryBias'] = $value;

        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setMaxRows(int $value): static
    {
        $this->params['maxRows'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setStyle(string $value): static
    {

        $validSizes = ['SHORT', 'MEDIUM', 'LONG', 'FULL'];

        if (!in_array($value, $validSizes, true)) {
            throw new \InvalidArgumentException("Invalid style value");
        }

        $this->params['style'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOperator(string $value): static
    {

        $validSizes = ['AND', 'OR'];

        if (!in_array($value, $validSizes, true)) {
            throw new \InvalidArgumentException("Invalid operator value");
        }

        $this->params['operator'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCharset(string $value): static
    {
        $this->params['charset'] = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setIsReduced(bool $value): static
    {
        $this->params['isReduced'] = $value;

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setEast(float $value): static
    {
        $this->params['east'] = $value;

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setWest(float $value): static
    {
        $this->params['west'] = $value;

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setNorth(float $value): static
    {
        $this->params['north'] = $value;

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setSouth(float $value): static
    {
        $this->params['south'] = $value;

        return $this;
    }


    /**
     * @param string $value
     * @return $this
     */
    public function setLatitude(string $value): static
    {
        $this->params['lat'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setLongitude(string $value): static
    {
        $this->params['lng'] = $value;
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setRadius(int $value): static
    {
        $this->params['radius'] = $value;
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setOption(array $params): static
    {
        $this->params = array_replace($this->params, $params);
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParam(string $key): bool
    {
        return isset($this->params[$key]);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

}
