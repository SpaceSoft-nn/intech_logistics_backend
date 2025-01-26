<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        //Грузы
        Schema::create('cargo_goods', function (Blueprint $table) {

            $table->uuid('id');

            $table->string('name_value')->nullable()->comment('Наименование груза');
            $table->string('product_type')->comment('Тип продукта: Бытовая техника, Грибы, древисина и т.д');

            $table->string('type_pallet')->comment('Тип паллета: eur, fin и т.д');

            //unsignedSmallInteger - когда-нибудь может быть проблема с этим типам
            $table->unsignedSmallInteger('cargo_units_count')->comment('Количество паллетов');
            $table->decimal('body_volume', 5 , 2)->comment('Общий объём паллетов');

            $table->text('description')->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('cargo_goods');
    }
};
