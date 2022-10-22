<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'merchant' => fake()->uuid(),
            'checkout' => fake()->uuid(),
            'receipt' => fake()->uuid(),
            'phone' => '2547'.fake()->randomNumber(8, true),
            'amount' => fake()->randomNumber(2, true),
            'date' => fake()->unixTime(),
        ];
    }
}
