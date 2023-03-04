<?php

namespace Mpietrucha\GoogleTagManager\Facades;

use Illuminate\Support\Facades\Facade;
use Mpietrucha\GoogleTagManager\GoogleTagManager as GoogleTagManagerContract;

class GoogleTagManager extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return GoogleTagManagerContract::class;
    }
}
