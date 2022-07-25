<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // motor type
        $motor_type = [4, 6, 8, 12];

        // oil type
        $oil_type = ['ديزل', 'بترول', 'غاز'];
        $model = $this->faker->numberBetween(2000, 2020);
        return [
            'name' => $this->faker->name(),
            'model' => $model,
            'year' => $model,
            'color' => $this->faker->hexColor(),
            'motor_type' => $this->faker->randomElement($motor_type),
            'oil_type' => $this->faker->randomElement($oil_type),
        ];
    }
}
