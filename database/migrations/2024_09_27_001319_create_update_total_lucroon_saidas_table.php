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
        Schema::create('update_total_lucroon_saidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nome_saida');
            $table->decimal('saida_lucro', 10, 2)->default(0); // Total de lucro do mês
            $table->enum('tipo', ['Gasto', 'Lucro']); // Tipo: Gasto ou Lucro
            $table->timestamps(); // Para registrar o mês e ano automaticamente
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_total_lucroon_saidas');
    }
};
