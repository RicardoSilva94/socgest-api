<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\notificacao;
use App\Models\Quota;
use App\Models\Socio;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\notificacao>
 */
class NotificacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quota_id' => Quota::factory(),
            'socio_id' => Socio::factory(),
            'mensagem' => $this->faker->sentence(),
            'estado' => $this->faker->randomElement(['pendente', 'enviada']),
            'data_envio' => $this->faker->dateTime(),
        ];
    }
}
