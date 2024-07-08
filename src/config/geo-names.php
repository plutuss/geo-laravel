<?php

use Plutuss\GeoNames\Response\Adapter\ArrayReportAdapter;
use Plutuss\GeoNames\Response\Adapter\CollectionReportAdapter;
use Plutuss\GeoNames\Response\Adapter\JsonReportAdapter;

return [

    /*
   |--------------------------------------------------------------------------
   | Geo Names
   |--------------------------------------------------------------------------
   |
   */
    'username' => env('GEO_NAMES_USERNAME', ''),
    'endpoint' => env('GEO_NAMES_ENDPOINT', 'http://api.geonames.org'),
    'country-code' => '', // 'DE','US','FR',


    'type_response' => [

        /**
         *  Arrays with wrapper with class Answer
         */
        'arrays_with_wrapper' => false,

        /**
         * You can choose the format of your answer
         *
         * collection, array, json
         */
        'default' => env('GEO_NAMES_RESPONSE', 'collection'),

        /**
         * You can change the response class by using ReportAdapterInterface in your class
         */
        'response_class' => [
            'collection' => CollectionReportAdapter::class,
            'array' => ArrayReportAdapter::class,
            'json' => JsonReportAdapter::class,
        ],

    ],

];
