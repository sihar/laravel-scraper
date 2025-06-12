<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TalentProfile>
 */
class TalentProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->name();

        return [
            'url' => fake()->unique()->url(),
            'name' => $name,
            'username' => Str::slug($name, '-'),
            'job_position' => fake()->word(),
            'summary_experience' => fake()->paragraph(),
        ];
    }
}
