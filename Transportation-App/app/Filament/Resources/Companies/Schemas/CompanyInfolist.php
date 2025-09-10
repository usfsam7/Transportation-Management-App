<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CompanyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('timezone'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
