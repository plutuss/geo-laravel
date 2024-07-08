<?php

namespace Plutuss\GeoNames\Response;

use Illuminate\Support\Collection;

class GeoNameResponse implements GeoNameResponseInterface
{

    /**
     * @var array
     */
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $path
     * @param mixed|null $default
     * @return mixed
     */
    public function getNestedValue(string $path, mixed $default = null): mixed
    {
        return data_get(
            $this->getArrayData(),
            $path,
            $default);
    }

    /**
     * @return mixed
     */
    public function latitude(): mixed
    {
        return $this->getNestedValue('lat');
    }


    public function getCollectionData(): Collection
    {
        return collect($this->data ?? []);
    }

    public function getArrayData(): array
    {
        return $this->data ?? [];
    }

    public function __get(string $name)
    {
        return $this->getNestedValue($name);
    }

    /**
     * @return mixed
     */
    public function longitude(): mixed
    {
        return $this->getNestedValue('lng');
    }

    /**
     * @return mixed
     */
    public function placeName(): mixed
    {
        return $this->getNestedValue('placeName');
    }

    /**
     * @return mixed
     */
    public function postalCode(): mixed
    {
        return $this->getNestedValue('postalCode');
    }

    /**
     * @return mixed
     */
    public function countryCode(): mixed
    {
        return $this->getNestedValue('countryCode');
    }

    /**
     * @return mixed
     */
    public function region(): mixed
    {
        return $this->getNestedValue('adminName2');
    }

    /**
     * @return mixed
     */
    public function land(): mixed
    {
        return $this->getNestedValue('adminName1');
    }


}
