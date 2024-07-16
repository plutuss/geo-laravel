<?php

namespace Plutuss\GeoNames\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GeoNameClientService
{

    private static ?GeoNameClientService $instance = null;
    private string $username;
    private string $endpoint;
    private array $params = [];

    /**
     * @param string $key
     * @param mixed $params
     * @return void
     */
    public function setParams(string $key, mixed $params): void
    {
        $this->params[$key] = $params;
    }

    public function __construct()
    {
        $this->initConfig();
    }

    private function initConfig(): void
    {
        $this->username = config('geo-names.username');
        $this->endpoint = config('geo-names.endpoint');
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

    /**
     * @param array $params
     * @return $this
     */
    public function setOption(array $params = []): static
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * @param string $method
     * @param array $params
     * @return Response
     */
    private function httpRequest(string $method, array $params = []): Response
    {
        return Http::get("$this->endpoint/$method", array_merge($params, $this->params));
    }

    /**
     * @param string $method
     * @param array $params
     * @return Response
     */
    public function apiRequest(string $method, array $params = []): Response
    {
        $this->setParams('username', $this->username);
        $this->setParams('type', 'json');

        return $this->httpRequest($method, $params);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParam(string $key): bool
    {
        return !empty($this->params) && isset($this->params[$key]);
    }
}
