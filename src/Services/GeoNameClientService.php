<?php

namespace Plutuss\GeoNames\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

class GeoNameClientService
{
    public function apiRequest(string $method, array $params = []): Response
    {
        $endpoint = rtrim(config('geo-names.endpoint'), '/');
        $params['username'] = config('geo-names.username');

        return Http::get("$endpoint/$method", $params);
    }

    public function getJson(string $method, array $params): array
    {
        $data = $this->apiRequest($method, $params)->throw()->json();

        if (!is_array($data)) {
            throw new UnexpectedValueException("GeoNames returned an invalid JSON response for $method.");
        }

        if (array_key_exists('status', $data)) {
            $message = $data['status']['message'] ?? 'Unknown error';
            $code = $data['status']['value'] ?? 0;

            throw new UnexpectedValueException("GeoNames $method: $message", (int) $code);
        }

        return $data;
    }
}
