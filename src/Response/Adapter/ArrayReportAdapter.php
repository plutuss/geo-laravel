<?php

namespace Plutuss\GeoNames\Response\Adapter;

use Plutuss\GeoNames\Response\GeoNameResponse;
use Plutuss\GeoNames\Response\GeoNameResponseInterface;

class ArrayReportAdapter implements ReportAdapterInterface
{

    public function getData(array $data, bool $arraysWithWrapper = false): array
    {
        if (!$arraysWithWrapper) {
            return $data;
        }

        return $this->arraysWithWrapperClassAnswer($data);

    }

    /**
     * @param $data
     * @return GeoNameResponseInterface[]
     */
    private function arraysWithWrapperClassAnswer($data): array
    {
        return collect($data)->map(function ($item): GeoNameResponseInterface {
            return new GeoNameResponse($item);
        })->toArray();
    }

}
