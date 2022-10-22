<?php

namespace Database\Factories;

use App\Models\ContactGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->name(),
            'phone' => '07'.fake()->randomNumber(8, true),
            'contact_group_id' => ContactGroup::factory(),
        ];
    }
}
