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
        Schema::create('pallets_space', function (Blueprint $table) {
            $table->uuid('id');

            $table->string('type_material')->default('wood');
            $table->string('type_size')->comment('тип паллета пример: EUR ширина:длина');
            $table->string('size')->nullable();
            $table->string('witght')->nullable();
            $table->string('max_witght')->nullable();
            $table->string('uuid_out')->comment('Уникальный индефикатор (QR) к примеру');
            $table->string('manufacture')->nullable()->comment('Производитель');
            $table->text('description')->nullable()->comment('Описание');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallets_space');
    }
};
