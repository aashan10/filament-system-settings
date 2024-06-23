<?php

namespace Aashan\FilamentSystemSettings;

use Filament\Panel;

class SystemSettings
{
    public static function register(Panel $panel): Panel
    {
        return $panel->discoverResources(in: __DIR__ . '/Filament/Resources', for: 'Aashan\\FilamentSystemSettings\\Filament\\Resources');
    }

}
