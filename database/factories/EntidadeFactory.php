<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Entidade;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\entidade>
 */
class EntidadeFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->company,
            'logotipo' => $this->faker->randomElement(['logo1.png', 'logo2.png', 'logo3.png']), // Exemplo de logotipo
            'nif' => $this->faker->numerify('#########'), // 9 dígitos para NIF
            'email' => $this->faker->unique()->companyEmail,
            'telefone' => $this->faker->phoneNumber,
            'morada' => $this->faker->address,
            'tipo_quota' => $this->faker->randomElement(['Anual', 'Mensal']),
            'valor_quota' => $this->faker->randomFloat(2, 10, 1000), // Valor entre 10 e 1000 com 2 casas decimais
            'user_id' => User::factory(), // Cria um user associado
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
