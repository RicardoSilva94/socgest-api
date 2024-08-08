<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Entidade;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\socio>
 */
class SocioFactory extends Factory
{
    protected static $socioNumber = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'nif' => $this->faker->numerify('#########'),
            'num_socio' => self::$socioNumber++,
            'telefone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'morada' => $this->faker->address(),
            'estado' => $this->faker->randomElement(['Activo', 'Desistiu', 'Faleceu', 'Expulso', 'Suspenso']),
            'notas' => $this->faker->sentence(),
            'entidade_id' => Entidade::factory(), // Cria uma entidade associada
            //
        ];
    }
}
