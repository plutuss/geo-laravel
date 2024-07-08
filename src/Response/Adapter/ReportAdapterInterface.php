<?php

namespace Plutuss\GeoNames\Response\Adapter;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface ReportAdapterInterface
{
    /**
     * @param array $data
     * @return array|JsonResponse|Collection
     */
    public function getData(array $data): array|JsonResponse|Collection;
}
