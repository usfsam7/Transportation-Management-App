<?php

use App\Models\Trip;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Company;
use Illuminate\Validation\ValidationException;

it('allows creating a non-overlapping trip', function () {
    $driver = Driver::factory()->create();
    $vehicle = Vehicle::factory()->create();
    $company = Company::factory()->create();

    Trip::factory()->create([
        'driver_id' => $driver->id,
        'vehicle_id' => $vehicle->id,
        'company_id' => $company->id,
        'starts_at' => now(),
        'ends_at' => now()->addHour(),
    ]);

    $trip = Trip::factory()->make([
        'driver_id' => $driver->id,
        'vehicle_id' => $vehicle->id,
        'company_id' => $company->id,
        'starts_at' => now()->addHours(2),
        'ends_at' => now()->addHours(3),
    ]);

    expect($trip->save())->toBeTrue();
});

it('prevents creating overlapping trip for same driver', function () {
    $driver = Driver::factory()->create();
    $vehicle = Vehicle::factory()->create();
    $company = Company::factory()->create();

    Trip::factory()->create([
        'driver_id' => $driver->id,
        'vehicle_id' => $vehicle->id,
        'company_id' => $company->id,
        'starts_at' => now(),
        'ends_at' => now()->addHour(),
    ]);

    $trip = new Trip([
        'driver_id' => $driver->id,
        'vehicle_id' => $vehicle->id,
        'company_id' => $company->id,
        'starts_at' => now()->addMinutes(30),
        'ends_at' => now()->addHours(2),
    ]);

    expect(fn () => $trip->save())->toThrow(ValidationException::class);
});
