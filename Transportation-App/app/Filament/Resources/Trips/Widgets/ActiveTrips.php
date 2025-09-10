<?php

namespace App\Filament\Resources\Trips\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Trip;

class ActiveTrips extends StatsOverviewWidget
{
        protected int|string|array $columnSpan = 1;
        protected ?string $pollingInterval = '60s'; // auto-refresh every 1 minute
    protected function getStats(): array
    {
        return [
            Stat::make('Active Trips', Trip::active()->count())
                ->description('Trips running right now')
                ->icon('heroicon-o-truck')
                ->color('success'),
        ];
    }
}
