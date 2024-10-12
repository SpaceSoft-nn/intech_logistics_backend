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
        Schema::create('matrix_distance', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('city_start_gar_id')->nullable()->comment('Значение Гар для города отправления');
            $table->uuid('city_end_gar_id')->nullable()->comment('Значение Гар для города прибытия');;

            $table->string('city_name_start')->comment('Название города отправки');
            $table->string('city_name_end')->comment('Название города прибытия');

            $table->float('distance')->comment('Дистанция');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrix_distance');
    }
};
