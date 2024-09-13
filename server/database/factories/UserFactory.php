<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition() : array
    {
        return [
            'name'           => fake()->name(),
            'email'          => fake()->unique()->safeEmail(),
            'phone'          => fake()->phoneNumber(),
            'position_id'    => Position::factory(),
            'photo'          => fake()->imageUrl(),
        ];
    }
}
