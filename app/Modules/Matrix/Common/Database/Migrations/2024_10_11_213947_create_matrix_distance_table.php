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
        #TODO Рассмотреть потом уникальность обязательно через gar_id т.к по названию городов записи могут быть неконсистентными из-за опечаток или разных вариантов написания
        Schema::create('matrix_distance', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('city_start_gar_id')->nullable()->comment('Значение Гар для города отправления');
            $table->uuid('city_end_gar_id')->nullable()->comment('Значение Гар для города прибытия');

            $table->string('city_name_start')->index()->comment('Название города отправки');
            $table->string('city_name_end')->index()->comment('Название города прибытия');

            $table->integer('distance')->comment('Дистанция');

            $table->timestamps();

            // Добавляем уникальный составной индекс
            $table->unique(['city_name_start', 'city_name_end'], ' unique_city');
            // $table->unique(['city_start_gar_id', 'city_end_gar_id'], 'unique_city_gar'); //должно быть, но fias по городам могут повторяться из-за того что fias отсчитывается от области

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
