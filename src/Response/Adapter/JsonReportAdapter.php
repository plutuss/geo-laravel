<?php

namespace Plutuss\GeoNames\Response\Adapter;

use Illuminate\Http\JsonResponse;

class JsonReportAdapter implements ReportAdapterInterface
{

    public function getData(array $data): JsonResponse
    {
        return response()->json([
            'data' => $data,
        ]);
    }
}
