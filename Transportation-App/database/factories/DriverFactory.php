<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Driver;
use App\Models\Company;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'company_id'     => Company::factory(),
            'name'           => $this->faker->name(),
            'license_number' => strtoupper($this->faker->bothify('??###')),
        ];
    }
}
