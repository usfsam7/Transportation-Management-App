<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Trip;
use Illuminate\Support\Facades\Cache;

class CompletedTrips extends StatsOverviewWidget
{
        protected int|string|array $columnSpan = 1;

    protected function getStats(): array
    {
        // Cache the completed trips count for 3 minutes seconds
        $completedTrips = Cache::remember('completed_trips_count_month', 180, function () {
            return Trip::where('status', 'completed')
                ->whereMonth('ends_at', now()->month)
                ->whereYear('ends_at', now()->year)
                ->count();
        });

        return [
            Stat::make('Trips Completed (This Month)', $completedTrips)
                ->description('Finished successfully this month')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
