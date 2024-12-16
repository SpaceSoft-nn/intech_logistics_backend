<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        //Таблица согласование когда Перевозчик возьмёт в работу заказ
        Schema::create('agreement_order_contractor_accept', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('agreement_order_contractor_id')->unique() #TODO - Возможно надо будет убирать unique
                ->constrained('agreement_order_contractors')->noActionOnDelete();

            $table->boolean('order_bool')->default(false)->comment('Подтврждения со стороны организации: заказчика');
            $table->boolean('contractor_bool')->default(false)->comment('Подтврждения со стороны организации: перевозчика');


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('agreement_order_contractor_accept');
    }
};
