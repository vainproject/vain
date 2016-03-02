<?php

namespace Vain\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Vain\Providers\VainServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            VainServiceProvider::class,
        ];
    }
}