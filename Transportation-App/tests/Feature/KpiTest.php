<?php

use App\Models\Trip;
use App\Models\Driver;
use App\Models\Vehicle;

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

it('counts available drivers correctly', function () {
    $availableDriver = Driver::factory()->create();

    $busyDriver = Driver::factory()->create();
    Trip::factory()->create([
        'driver_id' => $busyDriver->id,
        'starts_at' => now()->subHour(),
        'ends_at'   => now()->addHour(),
        'status'    => 'in_progress',
    ]);

    $availableCount = Driver::all()
        ->filter(fn ($driver) => $driver->isAvailableBetween(now(), now()->addHour()))
        ->count();

    expect($availableCount)->toBe(1);
});

it('counts available vehicles correctly', function () {
    $availableVehicle = Vehicle::factory()->create();

    $busyVehicle = Vehicle::factory()->create();
    Trip::factory()->create([
        'vehicle_id' => $busyVehicle->id,
        'starts_at'  => now()->subHour(),
        'ends_at'    => now()->addHour(),
        'status'     => 'in_progress',
    ]);

    $availableCount = Vehicle::all()
        ->filter(fn ($vehicle) => $vehicle->isAvailableBetween(now(), now()->addHour()))
        ->count();

    expect($availableCount)->toBe(1);
});
