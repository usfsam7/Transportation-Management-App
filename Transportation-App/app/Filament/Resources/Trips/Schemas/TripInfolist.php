<?php

namespace App\Filament\Resources\Trips\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TripInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('company.name')
                    ->numeric(),
                TextEntry::make('driver.name')
                    ->numeric(),
                TextEntry::make('vehicle.id')
                    ->numeric(),
                TextEntry::make('starts_at')
                    ->dateTime(),
                TextEntry::make('ends_at')
                    ->dateTime(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
