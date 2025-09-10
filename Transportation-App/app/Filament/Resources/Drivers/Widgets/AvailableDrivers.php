<?php

namespace App\Filament\Resources\Drivers\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Trip;
use App\Models\Driver;

class AvailableDrivers extends StatsOverviewWidget
{
        protected int|string|array $columnSpan = 1;

    protected function getStats(): array
    {
         $activeDriverIds = Trip::active()->pluck('driver_id')->unique();
        $availableDrivers = Driver::where('active', true)->whereNotIn('id', $activeDriverIds)->count();

        return [
            Stat::make('Available Drivers', $availableDrivers)
                ->description('Drivers free now')
                ->icon('heroicon-o-user')
                ->color('info'),
        ];
    }
}
