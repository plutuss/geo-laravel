<?php

namespace Plutuss\GeoNames\Facades;

use Illuminate\Support\Facades\Facade;



/**
// * @method static AMemberCheckAccessInterface|AMemberParametersApiInterface auth()
 *
 *
 *
// * @see \Plutuss\AMember\Contracts\AMemberInterface
 */
class GeoName  extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'geo.name.app';
    }

}
