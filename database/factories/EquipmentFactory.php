<?php

namespace Database\Factories;

use App\EquipmentStatus;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['Power Tools', 'Garden', 'Hand Tools', 'Ladders', 'Cleaning']),
            'description' => fake()->optional()->sentence(),
            'status' => EquipmentStatus::Active,
        ];
    }

    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EquipmentStatus::Maintenance,
        ]);
    }
}
