<?php

namespace Plutuss\GeoNames\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\GeoNames\Response\AdapterResponse;
use Plutuss\GeoNames\Traits\HasParameter;

class GeoNameService implements GeoNameServiceInterface
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
     * @return array|JsonResponse|Collection
     * @throws \Exception
     */
    private function getResponse($data): JsonResponse|array|Collection
    {

        if (isset($data)) {
            return AdapterResponse::getInstance()->getResponse($data);
        }

        throw new \Exception('Not found', 404);
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getCities()
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
    public function getCitiesFromPostCode(int $postalCode, int $radius = 5, int $maxRows = 10)
    {
        $data = $this->clientService
            ->setOption($postalCode)
            ->postalCodeSearchJSON($radius, $maxRows)
            ->json();

        return $this->getResponse($data['postalCodes']);

    }

    public function getCitiFromName(string $name, int $radius = 5, int $maxRows = 10)
    {
        $data = $this->clientService
            ->setOption($name)
            ->postalCodeSearchJSON($radius, $maxRows)
            ->json();

        return $this->getResponse($data['postalCodes']);

    }


    public function findNearbyPostalCodes(int $lat, int $lng)
    {
        $this->setLatitude($lat);
        $this->setLongitude($lng);

        $data = $this->clientService
            ->apiRequest('findNearbyPostalCodes')
            ->json();

        return $this->getResponse($data['postalCodes']);
    }


    public function postalCodeCountryInfo()
    {

        $data = $this->clientService
            ->apiRequest('postalCodeCountryInfo')
            ->json();

        return $this->getResponse($data['geonames']);
    }


    public function findNearbyJSON(int $lat, int $lng)
    {

        $this->setLatitude($lat);
        $this->setLongitude($lng);

        $data = $this->clientService
            ->apiRequest('findNearbyJSON')
            ->json();

        return $this->getResponse($data['geonames']);
    }


}
