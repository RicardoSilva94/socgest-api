<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Entidade;
use Illuminate\Support\Facades\Hash;

class UserEntidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar 10 users e para cada um, criar uma entidade associada
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                Entidade::factory()->create(['user_id' => $user->id]);
            });
    }
}
