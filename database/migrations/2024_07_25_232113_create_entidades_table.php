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
        Schema::create('entidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->binary('logotipo'); // `binary` é utilizado para blobs de dados binários
            $table->string('nif');
            $table->string('email');
            $table->string('telefone');
            $table->string('morada');
            $table->enum('tipo_quota', ['Anual', 'Mensal']);
            $table->decimal('valor_quota', 8, 2);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        // Definir a chave estrangeira após a tabela ser criada
        Schema::table('entidades', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entidades', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Remove a chave estrangeira
        });
        Schema::dropIfExists('entidades');
    }
};
