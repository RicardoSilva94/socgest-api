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
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quota_id');
            $table->unsignedBigInteger('socio_id');
            $table->text('mensagem'); // Mensagem da notificação
            $table->enum('estado', ['pendente', 'enviada'])->default('pendente'); // Status da notificação
            $table->timestamp('data_envio')->nullable();
            $table->timestamps(); // Adiciona created_at e updated_at

            // Define as chaves estrangeiras
            $table->foreign('quota_id')->references('id')->on('quotas')->onDelete('cascade');
            $table->foreign('socio_id')->references('id')->on('socios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notificacoes', function (Blueprint $table) {
            $table->dropForeign(['quota_id']); // Remove a chave estrangeira para quotas
            $table->dropForeign(['socio_id']); // Remove a chave estrangeira para socios
        });
        Schema::dropIfExists('notificacoes');
    }
};

