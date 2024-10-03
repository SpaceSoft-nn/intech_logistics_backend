<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        //Массо-габаритные-характеристики
        Schema::create('mgxs', function (Blueprint $table) {

            $table->uuid('id');

            $table->decimal('length', 10, 2)->nullable()->comment('Длина'); // Ширина
            $table->decimal('width', 10, 2)->nullable()->comment('Ширина'); // Длина
            $table->decimal('height', 10, 2)->nullable()->comment('Высота'); // Высота
            $table->decimal('weight', 10, 2)->comment('Вес'); // Вес

            $table->uuid('order_unit_id')->unique()->constrained('order_units')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mgx');
    }
};
