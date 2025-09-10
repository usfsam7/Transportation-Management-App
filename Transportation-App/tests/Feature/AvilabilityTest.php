<?php

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Trip;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('detects driver availability correctly', function () {
    $driver = Driver::factory()->create();
    $vehicle = Vehicle::factory()->create();

    // Trip currently blocking driver
    Trip::factory()->create([
        'driver_id' => $driver->id,
        'vehicle_id' => $vehicle->id,
        'starts_at' => now(),
        'ends_at' => now()->addHour(),
        'status' => 'in_progress',
    ]);

    // Free after 2–3 hours
    expect($driver->isAvailableBetween(now()->addHours(2), now()->addHours(3)))->toBeTrue();

    // Busy in the next 10–50 mins
    expect($driver->isAvailableBetween(now()->addMinutes(10), now()->addMinutes(50)))->toBeFalse();
});

it('detects vehicle availability correctly', function () {
    $vehicle = Vehicle::factory()->create();
    $driver = Driver::factory()->create();

    // Trip currently blocking vehicle
    Trip::factory()->create([
        'driver_id' => $driver->id,
        'vehicle_id' => $vehicle->id,
        'starts_at' => now(),
        'ends_at' => now()->addHour(),
        'status' => 'scheduled',
    ]);

    // Busy in the next 10–50 mins
    expect($vehicle->isAvailableBetween(now()->addMinutes(10), now()->addMinutes(50)))->toBeFalse();

    // Free after 2–3 hours
    expect($vehicle->isAvailableBetween(now()->addHours(2), now()->addHours(3)))->toBeTrue();
});
