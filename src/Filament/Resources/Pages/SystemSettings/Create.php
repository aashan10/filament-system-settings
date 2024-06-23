<?php

namespace Aashan\FilamentSystemSettings\Filament\Resources\Pages\SystemSettings;

use Aashan\FilamentSystemSettings\Filament\Resources\SystemSettingsResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;

class Create extends CreateRecord
{
    protected static string $resource = SystemSettingsResource::class;

    public function form(Form $form): Form
    {
        return SystemSettingsResource::forms($form);
    }
}
