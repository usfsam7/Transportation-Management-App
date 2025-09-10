<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Trip;
use App\Models\Vehicle;


class AvailableVehicles extends StatsOverviewWidget
{
        protected int|string|array $columnSpan = 1;

    protected function getStats(): array
    {
         $activeVehicleIds = Trip::active()->pluck('vehicle_id')->unique();
        $availableVehicles = Vehicle::where('active', true)->whereNotIn('id', $activeVehicleIds)->count();

        return [
            Stat::make('Available Vehicles', $availableVehicles)
                ->description('Vehicles free now')
                ->icon('heroicon-o-truck')
                ->color('warning'),
        ];
    }
}
