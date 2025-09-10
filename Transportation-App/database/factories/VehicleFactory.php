<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vehicle;
use App\Models\Company;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'plate'      => strtoupper($this->faker->bothify('??-####')),
            'model'      => $this->faker->word(),
        ];
    }
}
