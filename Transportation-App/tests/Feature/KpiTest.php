<?php

use App\Models\Trip;

it('counts active trips correctly', function () {
    Trip::factory()->create([
        'starts_at' => now()->subHour(),
        'ends_at' => now()->addHour(),
        'status' => 'in_progress',
    ]);

    expect(Trip::active()->count())->toBe(1);
});

it('counts completed trips this month correctly', function () {
    Trip::factory()->create([
        'starts_at' => now()->subDays(3),
        'ends_at' => now()->subDays(2),
        'status' => 'completed',
    ]);

    expect(
        Trip::where('status', 'completed')
            ->whereMonth('ends_at', now()->month)
            ->whereYear('ends_at', now()->year)
            ->count()
    )->toBe(1);
});
