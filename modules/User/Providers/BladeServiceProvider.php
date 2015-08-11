<?php namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('userbadge', function($expression) {
            return "<span class=\"label label-role role-<?php echo with{$expression}->roles()->ordered()->first()->color; ?>\"><?php echo with{$expression}->name; ?></span>";
        });
    }

    public function register()
    {
        //
    }
}