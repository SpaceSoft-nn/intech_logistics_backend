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

            $table->uuid('id')->primary();

            $table->decimal('length', 10, 2)->comment('Длина'); // Ширина
            $table->decimal('width', 10, 2)->comment('Ширина'); // Длина
            $table->decimal('height', 10, 2)->comment('Высота'); // Высота
            $table->decimal('weight', 10, 2)->comment('Вес'); // Вес

            $table->uuid('cargo_good_id')
                ->constrained('cargo_goods') // Устанавливаем связь с таблицей cargo_goods
                ->onDelete('cascade') // Удаляем mgx при удалении cargo_good
                ->unique(); // Это гарантирует, что каждый cargo_good может иметь только одну запись в mgx
          
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
