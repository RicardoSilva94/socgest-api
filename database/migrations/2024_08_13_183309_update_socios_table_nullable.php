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
        Schema::table('socios', function (Blueprint $table) {
            $table->string('nif')->nullable()->change();
            $table->string('telefone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('morada')->nullable()->change();
            $table->text('notas')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            $table->string('nif')->nullable(false)->change();
            $table->string('telefone')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('morada')->nullable(false)->change();
            $table->text('notas')->nullable(false)->change();
        });
    }
};
