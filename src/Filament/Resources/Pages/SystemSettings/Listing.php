<?php

namespace Aashan\FilamentSystemSettings\Filament\Resources\Pages\SystemSettings;

use Aashan\FilamentSystemSettings\Filament\Resources\SystemSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class Listing extends ListRecords
{
    protected static string $resource = SystemSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
