<?php

namespace Vain\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Vain\Console\Commands\Install;

class VainServiceProvider extends ServiceProvider
{
    protected $providers = [
        // Application Service Providers...
        ConfigServiceProvider::class,
        MenuServiceProvider::class,

        // Package service provider
        \Pingpong\Modules\ModulesServiceProvider::class,
        \Collective\Html\HtmlServiceProvider::class,
        \Dowilcox\KnpMenu\MenuServiceProvider::class,
        \DaveJamesMiller\Breadcrumbs\ServiceProvider::class,

        // In-app packages, may be excluded sometimes later
        \Vain\Packages\RealmAPI\Providers\RealmApiServiceProvider::class,
    ];

    protected $facades = [
        // Custom package facades
        'Inspiring' => \Illuminate\Foundation\Inspiring::class,
        'Menu' => \Dowilcox\KnpMenu\Facades\Menu::class,
        'Form' => \Collective\Html\FormFacade::class,
        'Html' => \Collective\Html\HtmlFacade::class,
        'Breadcrumbs' => \DaveJamesMiller\Breadcrumbs\Facade::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootTranslations();

        $this->bootViews();
    }

    protected function bootTranslations()
    {
        $langPath = __DIR__.'/../../../resources/lang';
        $this->loadTranslationsFrom($langPath, 'vain');

        $this->publishes([
            __DIR__.'/path/to/translations' => base_path('resources/lang/vendor/courier'),
        ]);
    }

    protected function bootViews()
    {
        $viewPath = __DIR__.'/../../../resources/views';
        $this->loadViewsFrom($viewPath, 'vain');

        $this->publishes([
            $viewPath => base_path('resources/views/vendor/vain'),
        ]);
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->registerServiceProviders();

        $this->registerFacades();

        $this->registerConsole();
    }

    protected function registerServiceProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();

        foreach ($this->facades as $alias => $class) {
            $loader->alias($alias, $class);
        }
    }

    protected function registerConsole()
    {
        $this->commands([
            Install::class
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Install::class
        ];
    }
}
