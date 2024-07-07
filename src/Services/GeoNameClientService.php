<?php

namespace Plutuss\GeoNames\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GeoNameClientService
{

    private static ?GeoNameClientService $instance = null;
    private string $username;
    private string $endpoint;
    private string $countryCode;
    private string|int $country;
    private array $params = [];

    public function setParams(string $key, mixed $params): void
    {
        $this->params[$key] = $params;
    }

    public function setCountryCode(string $countryCode): static
    {
        $this->countryCode = $countryCode;
    }


    public function __construct()
    {
        $this->username = config('geo-names.username');
        $this->endpoint = config('geo-names.endpoint');
        $this->countryCode = config('geo-names.country-code');
    }

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        if (!(static::$instance instanceof static)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function setOption(string $country, array $params = []): static
    {
        $this->country = trim($country);

        $this->params = array_merge($this->params, $params);

        return $this;
    }

    private function httpRequest(string $method, $params = []): Response
    {
        return Http::get("$this->endpoint/$method", array_merge($params, $this->params));
    }

    public function apiRequest(string $method, $params = []): Response
    {
        $this->setParams('username', $this->username);
        $this->setParams('type', 'json');

        return $this->httpRequest($method, $params);
    }

    public function searchJSON(): Response
    {

        $this->setParams('country', $this->params['country'] ?? $this->countryCode);
        $this->setParams('username', $this->username);

        return $this->httpRequest('searchJSON');

    }

    public function postalCodeSearchJSON(int $radius = 5, int $maxRows = 10): Response
    {
        $this->setParams('country', $this->params['country'] ?? $this->countryCode);
        $this->setParams('username', $this->username);
        $this->setParams('maxRows', $this->params['maxRows'] ?? $maxRows);
        $this->setParams('radius', $this->params['radius'] ?? $radius);

        if (is_numeric($this->country)) {
            $this->setParams('postalcode', $this->params['postalcode'] ?? $this->country);
        } else {
            $this->setParams('placename_startsWith', $this->params['placename_startsWith'] ?? $this->country);
        }

        return $this->httpRequest('postalCodeSearchJSON');

    }


}
