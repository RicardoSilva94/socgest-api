<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\quota;
use App\Models\Socio;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\quota>
 */
class QuotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data_emissao' => $this->faker->date(),
            'data_pagamento' => $this->faker->date(),
            'valor' => $this->faker->randomFloat(2, 5, 100), // Valor da quota entre 5 e 100
            'estado' => $this->faker->randomElement(['Pago', 'Não Pago']),
            'socio_id' => Socio::inRandomOrder()->first()->id, // Associar a um sócio existente,
        ];
    }
}
