<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\friendship>
 */
class FriendshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'requester_id' => $this->faker->randomDigit,
            'user_requested' => $this->faker->randomDigit,
            'created_at' => now(),
            'status'=>1,
        ];
    }
}
