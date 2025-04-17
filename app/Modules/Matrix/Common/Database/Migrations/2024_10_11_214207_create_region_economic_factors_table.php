<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('region_economic_factors', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('region_start_gar_id')->nullable()->comment('Значение Гар для области отправления');
            $table->uuid('region_end_gar_id')->nullable()->comment('Значение Гар для области прибытия');;

            $table->string('region_name_start')->index()->comment('Название области отправки');
            $table->string('region_name_end')->index()->comment('Название области прибытия');

            $table->float('factor')->default(1)->comment('коэффициент');

            $table->integer('distance')->nullable()->comment('Дистанция');

            $table->decimal('price', 10, 2)->comment('Общая цена');
            $table->decimal('price_form_km', 10, 2)->nullable()->comment('цена за 1 км');

            $table->string('type')->nullable()->comment('тип перевозки пример: ftl, ltl, деловые линии');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();


            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('region_economic_factors');
    }

};
