<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id(); // Cria a coluna id como chave primária
            $table->string('nome');
            $table->string('nif');
            $table->string('num_socio');
            $table->string('telefone');
            $table->string('email');
            $table->string('morada');
            $table->enum('estado', ['Activo', 'Desistiu', 'Faleceu', 'Expulso', 'Suspenso'])->default('Activo');
            $table->text('notas'); // Alterado de string para text para armazenar mais texto, se necessário
            $table->timestamps();
            $table->unsignedBigInteger('entidade_id'); // Adiciona a coluna entidade_id
        });

        // Define a chave estrangeira após a tabela ser criada
        Schema::table('socios', function (Blueprint $table) {
            $table->foreign('entidade_id')->references('id')->on('entidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            $table->dropForeign(['entidade_id']); // Remove a chave estrangeira
        });
        Schema::dropIfExists('socios'); // Remove a tabela
    }
};

