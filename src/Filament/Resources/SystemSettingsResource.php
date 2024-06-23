<?php

namespace Aashan\FilamentSystemSettings\Filament\Resources;

use Aashan\FilamentSystemSettings\Filament\Table\Columns\SystemSettingsColumn;
use Aashan\FilamentSystemSettings\Models\SystemSetting;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Crypt;


class SystemSettingsResource extends \Filament\Resources\Resource
{

    protected static ?string $model = SystemSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function forms(Form $form): Form
    {
        return $form->schema([
            Section::make()->columns(1)->schema([
                TextInput::make('key')->label('Key')->required(),
                Textarea::make('value')->label('Value')->required(),
                Toggle::make('is_encrypted')->label('Encrypt Value')->onIcon('heroicon-o-lock-closed')->offIcon('heroicon-o-lock-open')
            ]),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table->columns([

            TextColumn::make('key')->label('Key')->searchable()->sortable(),
            SystemSettingsColumn::make('value')
                ->label('Value')
                ->formatStateUsing(fn(SystemSetting $setting) => !$setting->is_encrypted ? $setting->value : '***')
                ->copyable()
                ->copyableState(function (SystemSetting $setting): string {
                    if ($setting->is_encrypted) {
                        try {
                            return Crypt::decryptString($setting->value);
                        } catch (\Exception $e) {
                            return 'Could not decrypt value';
                        }
                    }
                    return $setting->value;
                })

        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\SystemSettings\Listing::route('/'),
            'create' => Pages\SystemSettings\Create::route('/create'),
            'edit' => Pages\SystemSettings\Edit::route('/{record}/edit')
        ];
    }
}
