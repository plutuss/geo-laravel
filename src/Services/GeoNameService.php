<?php

namespace Plutuss\GeoNames\Services;

use Illuminate\Support\Collection;
use Plutuss\GeoNames\Response\GeoNameResponse;
use Plutuss\GeoNames\Response\GeoNameResponseInterface;
use Plutuss\GeoNames\Traits\HasParameter;

class GeoNameService
{

    use HasParameter;

    private static ?GeoNameService $instance = null;

    public function __construct(
        protected readonly GeoNameClientService $clientService,
    )
    {
    }

    /**
     * @return static
     */
    public static function getInstance($clientService): static
    {
        if (!(static::$instance instanceof static)) {
            static::$instance = new static($clientService);
        }

        return static::$instance;
    }

    /**
     * @param $data
     * @return Collection
     * @throws \Exception
     */
    private function getResponse($data): Collection
    {
        if (isset($data)) {
            return collect($data)->map(function ($item): GeoNameResponseInterface {
                return new GeoNameResponse($item);
            });
        }

        throw new \Exception('No found');
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getCities(): Collection
    {
        $data = $this->clientService->searchJSON()->json();

        return $this->getResponse($data['geonames']);
    }

    /**
     * @param int $postalCode
     * @param int $radius
     * @param int $maxRows
     * @return Collection
     * @throws \Exception
     */
    public function getCitiesFromPostCode(int $postalCode, int $radius = 5, int $maxRows = 10): Collection
    {
        $data = $this->clientService
            ->setOption($postalCode)
            ->postalCodeSearchJSON($radius, $maxRows)
            ->json();

        return $this->getResponse($data['postalCodes']);

    }

    /**
     * @param string $name
     * @param int $radius
     * @param int $maxRows
     * @return Collection
     * @throws \Exception
     */
    public function getCitiFromName(string $name, int $radius = 5, int $maxRows = 10): Collection
    {
        $data = $this->clientService
            ->setOption($name)
            ->postalCodeSearchJSON($radius, $maxRows)
            ->json();

        return $this->getResponse($data['postalCodes']);

    }


    /**
     * @param int $lat
     * @param int $lng
     * @return Collection
     * @throws \Exception
     */
    public function findNearbyPostalCodes(int $lat, int $lng): Collection
    {
        $this->setLatitude($lat);
        $this->setLongitude($lng);

        $data = $this->clientService
            ->apiRequest('findNearbyPostalCodes')
            ->json();

        return $this->getResponse($data['postalCodes']);
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function postalCodeCountryInfo(): Collection
    {

        $data = $this->clientService
            ->apiRequest('postalCodeCountryInfo')
            ->json();

        return $this->getResponse($data['geonames']);
    }

    /**
     * @param int $lat
     * @param int $lng
     * @return Collection
     * @throws \Exception
     */
    public function findNearbyJSON(int $lat, int $lng): Collection
    {

        $this->setLatitude($lat);
        $this->setLongitude($lng);

        $data = $this->clientService
            ->apiRequest('findNearbyJSON')
            ->json();

        return $this->getResponse($data['geonames']);
    }


}
