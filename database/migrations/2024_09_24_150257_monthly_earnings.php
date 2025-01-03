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
        Schema::create('monthly_earnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_lucro', 10, 2)->default(0); 
            $table->decimal('total_gasto', 10, 2)->default(0); 
            $table->decimal('valor_corrida', 10, 2)->default(0); 
            $table->timestamps(); // Para registrar o mês e ano automaticamente
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_earnings');
    }
};
