<?php

namespace App\Filament\Resources\Trips\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\Vehicle;

class TripForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required(),

                DateTimePicker::make('starts_at')
                    ->required()
                    ->reactive(),

                DateTimePicker::make('ends_at')
                    ->required()
                    ->reactive(),

                Select::make('driver_id')
                    ->label('Driver')
                    ->options(function ($get) {
                        $start = $get('starts_at');
                        $end = $get('ends_at');

                        if (!$start || !$end) {
                            return Driver::all()->pluck('name', 'id');
                        }

                        // Only available drivers for this time
                        $driverIds = Trip::where(function ($q) use ($start, $end) {
                            $q->where('starts_at', '<', $end)
                              ->where('ends_at', '>', $start);
                        })->pluck('driver_id')->toArray();

                        return Driver::whereNotIn('id', $driverIds)
                                     ->pluck('name', 'id');
                    })
                    ->required(),

                Select::make('vehicle_id')
                    ->label('Vehicle')
                    ->options(function ($get) {
                        $start = $get('starts_at');
                        $end = $get('ends_at');

                        if (!$start || !$end) {
                            return Vehicle::all()->pluck('model', 'id');
                        }

                        // Only available vehicles for this time
                        $vehicleIds = Trip::where(function ($q) use ($start, $end) {
                            $q->where('starts_at', '<', $end)
                              ->where('ends_at', '>', $start);
                        })->pluck('vehicle_id')->toArray();

                        return Vehicle::whereNotIn('id', $vehicleIds)
                                      ->pluck('model', 'id');
                    })
                    ->required(),

                Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'in_progress' => 'In progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('scheduled')
                    ->required(),
            ]);
    }
}
