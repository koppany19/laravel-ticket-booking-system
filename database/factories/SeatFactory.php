<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seat_number' => $this->faker->regexify('[A-Z][0-9][0-9][0-9]'),
            'base_price' => $this->faker->numberBetween(6000, 21000),
        ];
    }
}
