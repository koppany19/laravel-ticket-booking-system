<?php

namespace Database\Factories;

use App\Models\Seat;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barcode' => $this->faker->unique()->regexify('[0-9]{9}'),
            'admission_time' => null,
            'user_id' => User::factory(),
            'seat_id' => Seat::factory(),
            'event_id' => Event::factory(),
            'price' => $this->faker->randomFloat( 2, 5400, 13900),
        ];
    }
}
