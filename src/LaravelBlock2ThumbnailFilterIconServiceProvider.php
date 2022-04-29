<?php

namespace GMJ\LaravelBlock2ThumbnailFilterIcon;

use GMJ\LaravelBlock2ThumbnailFilterIcon\View\Components\Frontend;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelBlock2ThumbnailFilterIconServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__ . "/routes/web.php", 'LaravelBlock2ThumbnailFilterIcon');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'LaravelBlock2ThumbnailFilterIcon');
        $this->loadViewsFrom(__DIR__ . '/resources/views/config', 'LaravelBlock2ThumbnailFilterIcon.config');

        Blade::component("LaravelBlock2ThumbnailFilterIcon", Frontend::class);

        $this->publishes([
            __DIR__ . '/config/laravel_block2_thumbnail_filter_icon_config.php' => config_path('gmj/laravel_block2_thumbnail_filter_icon_config.php'),
            __DIR__ . '/database/seeders' => database_path('seeders'),
        ], 'GMJ\LaravelBlock2ThumbnailFilterIcon');
    }


    public function register()
    {
    }
}
