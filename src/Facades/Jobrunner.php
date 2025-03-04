<?php

namespace BeInteractive\Jobrunner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BeInteractive\Jobrunner\Jobrunner
 */
class Jobrunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BeInteractive\Jobrunner\Jobrunner::class;
    }
}
