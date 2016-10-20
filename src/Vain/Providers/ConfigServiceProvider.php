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

        $this->mergeConfigFrom(
            __DIR__.'/../../../config/laravel-medialibrary.php', 'laravel-medialibrary'
        );
    }

    public function boot()
    {
        // set media disk
        $currentDiskConfig = $this->app['config']->get('filesystems.disks', []);

        $this->app['config']->set('filesystems.disks', array_merge($currentDiskConfig, [
            'defaultMedia' => [
                'driver' => 'local',
                'root'   => public_path().'/media',
            ]
        ]));
    }
}
