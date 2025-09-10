<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('license_number'),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
