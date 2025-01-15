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

            $table->string('region_name_start')->comment('Название области отправки');
            $table->string('region_name_end')->comment('Название области прибытия');

            $table->float('factor')->comment('коэффициент');
            $table->decimal('price', 10, 2)->comment('цена за 1 км');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('region_economic_factors');
    }

};
