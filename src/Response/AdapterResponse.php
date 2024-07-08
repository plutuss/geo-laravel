<?php

namespace Plutuss\GeoNames\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class AdapterResponse
{
    private string $typeResponse;
    private bool $arraysWithWrapper = false;
    private array $responseClass;

    /**
     * @var null|static
     */
    private static ?AdapterResponse $instance = null;

    public function __construct()
    {
        $this->typeResponse = config('geo-names.type_response.default');
        $this->responseClass = config('geo-names.type_response.response_class');
        $this->arraysWithWrapper = config('geo-names.type_response.arrays_with_wrapper');
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

    public function getResponse(mixed $data): array|JsonResponse|Collection
    {
        return match ($this->typeResponse) {
            'collection' => (new $this->responseClass['collection'])->getData($data),
            'array' => (new $this->responseClass['array'])->getData($data, $this->arraysWithWrapper),
            'json' => (new $this->responseClass['json'])->getData($data),
            default => $data,
        };
    }
}
