<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Quality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(10),
            'price' => $this->faker->randomDigit(),
            'quality_id' => rand(1, Quality::count()),
            'piece_number' => rand(1, 100),
            'percentage_of_sale' => 5,
        ];
    }
}
