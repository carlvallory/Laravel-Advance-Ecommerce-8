<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PagoparFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pagopar';
    }
}
