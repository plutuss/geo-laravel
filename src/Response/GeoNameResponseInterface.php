<?php

namespace Plutuss\GeoNames\Response;

use Illuminate\Support\Collection;

interface GeoNameResponseInterface
{

    public function latitude(): mixed;

    public function getCollectionData(): Collection;

    public function getArrayData(): array;

    public function longitude(): mixed;

    public function placeName(): mixed;

    public function postalCode(): mixed;

    public function countryCode(): mixed;

    public function region(): mixed;

    public function land(): mixed;

    /**
     * @param string $path
     * @param mixed|null $default
     * @return mixed
     */
    public function getNestedValue(string $path, mixed $default = null): mixed;

}
