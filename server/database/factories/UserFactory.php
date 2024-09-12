<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition() : array
    {
        return [
            'name'           => fake()->name(),
            'email'          => fake()->unique()->safeEmail(),
            'password'       => Hash::make('password'),
            'phone'          => fake()->phoneNumber(),
            'position_id'    => Position::factory(),
            'photo'          => fake()->imageUrl(),
        ];
    }
}
