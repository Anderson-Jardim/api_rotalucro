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
        Schema::create('infoones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            /* $table->decimal('valor_gasolina', 8, 2); */
            $table->integer('dias_trab');
            $table->integer('qtd_corridas');
            /* $table->decimal('km_litro', 8, 2); */
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infoones');
    }
};
