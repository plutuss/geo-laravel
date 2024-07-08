<?php

namespace Plutuss\GeoNames\Response\Adapter;

use Illuminate\Support\Collection;
use Plutuss\GeoNames\Response\GeoNameResponse;
use Plutuss\GeoNames\Response\GeoNameResponseInterface;

class CollectionReportAdapter implements ReportAdapterInterface
{

    /**
     * @param array $data
     * @return Collection
     */
    public function getData(array $data): Collection
    {
        return collect($data)->map(function ($item): GeoNameResponseInterface {
            return new GeoNameResponse($item);
        });
    }
}
