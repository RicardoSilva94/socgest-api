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
            $table->enum('tipo', ['Anual', 'Mensal'])->after('socio_id');

            $table->string('periodo', 50)->nullable()->after('tipo');

            $table->string('descricao', 255)->nullable()->after('valor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotas', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'periodo', 'descricao']);
        });
    }
};
