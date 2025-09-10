<?php

namespace App\Filament\Resources\Trips\Pages;

use App\Filament\Resources\Trips\TripResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrip extends ViewRecord
{
    protected static string $resource = TripResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
