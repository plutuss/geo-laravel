<?php

namespace Plutuss\GeoNames\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\GeoNames\Response\AdapterResponse;
use Plutuss\GeoNames\Traits\HasParameter;

class GeoNameService implements GeoNameServiceInterface
{

    use HasParameter;

    private string $countryCode;

    private static ?GeoNameService $instance = null;

    public function __construct(
        protected readonly GeoNameClientService $clientService,
    )
    {
        $this->countryCode = config('geo-names.country-code');
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
     * @param string|null $country
     * @return JsonResponse|array|Collection
     * @throws \Exception
     */
    public function searchJSON(string $country = null): JsonResponse|array|Collection
    {

        if ($country) $this->setCountry($country);
        if ($this->countryCode) $this->setCountryCode($this->countryCode);

        $data = $this->clientService
            ->apiRequest('searchJSON')
            ->json();

        return $this->getResponse($data['geonames'] ?? $data);
    }


    /**
     * @param int $postalCode
     * @param int $radius
     * @param int $maxRows
     * @return JsonResponse|array|Collection
     * @throws \Exception
     */
    public function postalCodeSearchJSONFromPostCode(int $postalCode, int $radius = 5, int $maxRows = 10): JsonResponse|array|Collection
    {

        $this->setCountryCode($this->countryCode);
        $this->setPostalCode($postalCode);

        $this->setRadius($radius);
        $this->setMaxRows($maxRows);

        $data = $this->clientService
            ->apiRequest('postalCodeSearchJSON')
            ->json();

        return $this->getResponse($data['postalCodes'] ?? $data);
    }

    /**
     * @param string $name
     * @param int $radius
     * @param int $maxRows
     * @return JsonResponse|array|Collection
     * @throws \Exception
     */
    public function postalCodeSearchJSONFromName(string $name, int $radius = 5, int $maxRows = 10): JsonResponse|array|Collection
    {
        $this->setPlaceNameStartsWith($name);
        $this->setCountryCode($this->countryCode);

        $this->setRadius($radius);
        $this->setMaxRows($maxRows);

        $data = $this->clientService
            ->apiRequest('postalCodeSearchJSON')
            ->json();

        return $this->getResponse($data['postalCodes'] ?? $data);

    }

    /**
     * @param int $lat
     * @param int $lng
     * @return JsonResponse|array|Collection
     * @throws \Exception
     */
    public function findNearbyPostalCodes(int $lat, int $lng): JsonResponse|array|Collection
    {
        $this->setLatitude($lat);
        $this->setLongitude($lng);

        $data = $this->clientService
            ->apiRequest('findNearbyPostalCodes')
            ->json();

        return $this->getResponse($data['postalCodes'] ?? $data);
    }

    /**
     * @return JsonResponse|array|Collection
     * @throws \Exception
     */
    public function postalCodeCountryInfo(): JsonResponse|array|Collection
    {

        $data = $this->clientService
            ->apiRequest('postalCodeCountryInfo')
            ->json();

        return $this->getResponse($data['geonames'] ?? $data);
    }

    /**
     * @param int $lat
     * @param int $lng
     * @return JsonResponse|array|Collection
     * @throws \Exception
     */
    public function findNearbyJSON(int $lat, int $lng): JsonResponse|array|Collection
    {

        $this->setLatitude($lat);
        $this->setLongitude($lng);

        $data = $this->clientService
            ->apiRequest('findNearbyJSON')
            ->json();

        return $this->getResponse($data['geonames'] ?? $data);
    }

}
