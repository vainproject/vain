<?php

namespace Vain\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Overwrite any vendor / package configuration.
     *
     * This service provider is intended to provide a convenient location for you
     * to overwrite any "vendor" or package configuration that you may want to
     * modify before the application handles the incoming request / command.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../../config/app.php', 'app'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../../../config/breadcrumbs.php', 'breadcrumbs'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../../../config/menu.php', 'menu'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../../../config/modules.php', 'modules'
        );
    }
}
