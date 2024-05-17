<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnostic>
 */
class DiagnosticFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->text(),
        ];
    }
}
