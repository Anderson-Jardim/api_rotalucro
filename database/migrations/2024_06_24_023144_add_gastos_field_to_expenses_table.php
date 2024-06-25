<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('expenses', function (Blueprint $table) {
        $table->json('gastos')->nullable();
        $table->dropColumn('name');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('expenses', function (Blueprint $table) {
        $table->string('name');
        $table->dropColumn('gastos');
    });
}
};
