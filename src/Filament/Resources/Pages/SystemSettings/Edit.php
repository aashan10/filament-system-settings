<?php

namespace Aashan\FilamentSystemSettings\Filament\Resources\Pages\SystemSettings;

use Aashan\FilamentSystemSettings\Filament\Resources\SystemSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;

class Edit extends EditRecord
{
    protected static string $resource = SystemSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->columns(1)->schema([
                TextInput::make('key')->label('Key')->required(),
                Textarea::make('value')->label('Value')->extraInputAttributes([ 'readonly' => $this->record?->is_encrypted ])->required(),
                Toggle::make('is_encrypted')->label('Encrypt Value')->onIcon('heroicon-o-lock-closed')->offIcon('heroicon-o-lock-open')
            ]),
        ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $previouslyEncrypted = $this->record?->is_encrypted ?? false;
        $shouldEncrypt = $data['is_encrypted'] ?? false;
        $isValueDifferent = $this->record?->value !== $data['value'];

        try {
            if ($previouslyEncrypted && !$shouldEncrypt) {
                $data['value'] = Crypt::decryptString($this->record?->value);
            } elseif (!$previouslyEncrypted && $shouldEncrypt) {
                $data['value'] = Crypt::encryptString($isValueDifferent ? $data['value'] : $this->record?->value);
            }
        } catch (\Throwable $e) {}


        return $data;
    }
}
