<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {//Лот тендера
        Schema::create('lot_tenders', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->unsignedSmallInteger('general_count_transport')->comment('количество транспорта');

            $table->double('price_for_km')->comment('количество транспорта');
            $table->double('body_volume_for_order')->comment('количество объёма на 1 заказ');

            $table->string("type_transport_weight")->comment('Тип транспортного средства: small - 1.5-3тонны, medium 5-10тонны');
            $table->string("type_load_truck")->comment('Тип транспортного средства: small - 1.5-3тонны, medium 5-10тонны');

            $table->string("status_tender")->default('Черновик')->comment('Статус Тендера: в работе, черновик..');
            $table->string("type_tender")->comment('Разовый/Переодический');

            $table->date('date_start')->comment('Дата начало тендера');

            $table->unsignedSmallInteger('period')->comment('Количество дней, например в течении 60 дней');
            $table->unsignedSmallInteger('day_period')->nullable()->comment('Как должен выполняться тендер пример: каждые 5 дней');

            $table->foreignUuid('organization_id')
                ->constrained('organizations')->noActionOnDelete();


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('lot_tenders');
    }
};
