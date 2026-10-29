<?php

namespace Database\Factories;

use App\Models\SupportTicket;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->words(4, true),
            'description' => fake()->text(250),
            'category' => fake()->randomElement(array('soporte','mantenimiento','instalación','otro')),
            'priority' => fake()->randomElement(array('baja','media','alta','crítica')),
            'status' => fake()->randomElement(array('abierto','en_proceso','resuelto','cerrado')),
            'image_path' => fake()->imageUrl(640,480,'animals'),
            'cancelado' => fake()->boolean(30),
            'due_date' => fake()->date('Y-m-d', '+10 month')
        ];
    }
}
