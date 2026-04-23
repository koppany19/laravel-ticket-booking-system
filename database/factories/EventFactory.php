<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(['Pamkutya Koncert 1 nap', 'Pamkutya Koncert 2 nap', 'Pamkutya Koncert 3 nap', 'Pamkutya Koncert 4 nap', 'Pamkutya Koncert 5 nap', 'Pamkutya Koncert 6 nap', 'Pamkutya Koncert 7 nap']),
            'description' => $this->faker->text(1000),
            'event_date_at' => $this->faker->dateTimeBetween('+4month +1week', '+5month'),
            'sale_start_at' => $this->faker->dateTimeBetween('+1week', '+2week'),
            'sale_end_at' => $this->faker->dateTimeBetween('+3month', '+4month'),
            'is_dynamic_price' => $this->faker->boolean(45),
            'max_number_allowed' => $this->faker->numberBetween(4, 7),
            'image' => 'https://picsum.photos/seed/' . rand(1, 1000) .'200/300',
        ];
    }
}
