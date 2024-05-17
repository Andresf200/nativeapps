<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'document' => fake()->unique()->randomNumber(8),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'birth_date' => fake()->date(),
            'email' => fake()->unique()->safeEmail,
            'phone' => fake()->phoneNumber,
            'genre' => fake()->randomElement(['female', 'male'])
        ];
    }
}
