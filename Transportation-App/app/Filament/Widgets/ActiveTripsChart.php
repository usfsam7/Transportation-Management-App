<?php

namespace App\Filament\Widgets;

use App\Models\Trip;
use Filament\Widgets\ChartWidget;

class ActiveTripsChart extends ChartWidget
{
    protected  ?string $pollingInterval = '60s';

    public function getHeading(): string
    {
        return 'Trips by Status';
    }

    protected function getType(): string
    {
        return 'line'; // options: line, bar, area, donut, pie
    }

    protected function getData(): array
    {
        $statuses = ['scheduled', 'in_progress', 'completed', 'cancelled'];

        $counts = collect($statuses)
            ->map(fn($status) => Trip::where('status', $status)->count())
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Trips',
                    'data' => $counts,
                ],
            ],
            'labels' => ['Scheduled', 'In Progress', 'Completed', 'Cancelled'],
        ];
    }
}
