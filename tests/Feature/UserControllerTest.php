<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;


class UserControllerTest extends TestCase
{
    /**
     * Tests the User Controller
     */
    public function test_index_returns_users()
    {
        $user = User::first();

        $response = $this->actingAs($user)->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'entidade_id',
                    ],
                ],
            ]);
    }

    public function test_destroy_removes_user_and_entidade()
    {
        // Cria um user com entidade associada
        $user = User::factory()->create();
        $entidade = $user->entidade ? $user->entidade : null;

        // Simula a autenticação do user
        $this->actingAs($user);

        // Faz a requisição DELETE para a rota de destroy
        $response = $this->deleteJson('/api/users');

        // Verifica se a resposta tem o status 200 e a mensagem correta
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'A sua conta foi eliminada com sucesso.',
            ]);

        // Verifica se o user foi eliminado
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);

        // Verifica se a entidade tambem foi eliminada
        if ($entidade) {
            $this->assertDatabaseMissing('entidades', [
                'id' => $entidade->id,
            ]);
        }

        // e vê se o token do user também foi eliminado
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_changeName_updates_user_name()
    {
        // Cria um user
        $user = User::factory()->create();

        // Simula a autenticação do user
        $this->actingAs($user);
        //cria sempre um nome único
        $uniqueName = 'Novo Nome ' . uniqid();

        // Faz a requisição POST para a rota de change-name
        $response = $this->postJson('/api/change-name', [
            'name' => $uniqueName,
        ]);

        // Verifica se a resposta tem o status 200 e a mensagem correta
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Username changed successfully!',
            ]);

        // Verifica se o nome do user foi alterado
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $uniqueName,
        ]);
    }

    public function test_changePassword_updates_user_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('old_password'),
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/api/change-password', [
            'current_password' => 'old_password',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Password changed successfully!',
            ]);

        $this->assertTrue
        (Hash::check('new_password', $user->fresh()->password),
            'A password não foi alterada corretamente.');
    }

}
