<?php

namespace Database\Factories;

use App\Models\BillStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id' => rand(1, User::count()),
            'payer_id' => rand(1, User::count()),
            'status_id' => rand(1, BillStatus::count()),
            'payment_method' => $this->faker->randomElement(['a', 'b']),
            'confirm_code' => null,
            'date' => $this->faker->date,
            'total' => rand(100, 100000),
        ];
    }
}
