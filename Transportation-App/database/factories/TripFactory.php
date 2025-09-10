<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Trip;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Vehicle;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        $starts = $this->faker->dateTimeBetween('-10 days', '+10 days');
        $ends   = (clone $starts)->modify('+' . (2 + $this->faker->numberBetween(0, 2)) . ' hours');

        return [
            'company_id' => Company::factory(),
            'driver_id'  => Driver::factory(),
            'vehicle_id' => Vehicle::factory(),
            'starts_at'  => $starts,
            'ends_at'    => $ends,
            'status'     => 'scheduled',
        ];
    }

    public function active(): self
    {
        return $this->state(function () {
            $starts = now()->subMinutes(rand(0, 30));
            $ends   = now()->addMinutes(rand(30, 120));

            return [
                'starts_at' => $starts,
                'ends_at'   => $ends,
                'status'    => 'in_progress',
            ];
        });
    }
}
