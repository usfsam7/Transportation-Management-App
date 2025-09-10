<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed 5 active trips
    Trip::factory()->count(5)->active()->create();

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Company::factory()->count(3)->create()->each(function($company) {
        $drivers = \App\Models\Driver::factory()->count(8)->create(['company_id'=>$company->id]);
        $vehicles = \App\Models\Vehicle::factory()->count(6)->create(['company_id'=>$company->id]);

        // Attach drivers to vehicles (qualifications)
        foreach($drivers as $driver) {
            $driver->vehicles()->attach($vehicles->random(rand(1,3))->pluck('id')->toArray());
        }

        // Create some scheduled trips (careful to avoid overlap by naive approach)
        for ($i=0;$i<12;$i++) {
            $driver = $drivers->random();
            $vehicle = $driver->vehicles()->inRandomOrder()->first() ?? $vehicles->random();
            $starts = now()->addDays(rand(-5,5))->addHours(rand(6,20))->startOfHour();
            $ends = (clone $starts)->addHours(rand(1,3));
            try {
                \App\Models\Trip::create([
                    'company_id'=>$company->id,
                    'driver_id'=>$driver->id,
                    'vehicle_id'=>$vehicle->id,
                    'starts_at'=>$starts,
                    'ends_at'=>$ends,
                    'status'=>'scheduled'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                // skip
            }
        }
    });
    }
}
