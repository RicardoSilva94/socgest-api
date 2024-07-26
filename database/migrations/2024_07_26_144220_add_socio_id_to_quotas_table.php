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
        Schema::table('quotas', function (Blueprint $table) {
            // Adiciona a coluna socio_id
            $table->unsignedBigInteger('socio_id')->after('id');

            // Define a chave estrangeira
            $table->foreign('socio_id')->references('id')->on('socios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotas', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['socio_id']);

            // Remove a coluna socio_id
            $table->dropColumn('socio_id');
        });
    }
};
