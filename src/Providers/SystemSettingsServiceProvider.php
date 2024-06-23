<?php


namespace Aashan\FilamentSystemSettings\Providers;

use Illuminate\Support\ServiceProvider;


class SystemSettingsServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'filament-system-settings');
    }

}
