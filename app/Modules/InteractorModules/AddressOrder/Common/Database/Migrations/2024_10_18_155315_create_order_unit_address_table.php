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
        Schema::create('order_unit_Address', function (Blueprint $table) {

            $table->id('id')->primary();

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            $table->uuid('Address_id')
                ->constrained('addresses')->noActionOnDelete();

            $table->date('data_time');

            $table->string('type');

            $table->integer('priority')->default(null)->comment('Приоритетность - с помощью этого поля поймём вектор движение между адрессами');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_unit_Address');
    }
};
