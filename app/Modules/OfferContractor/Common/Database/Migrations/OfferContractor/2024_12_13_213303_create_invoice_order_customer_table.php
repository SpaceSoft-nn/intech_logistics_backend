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
        // Информация при отклике от Заказчика для перевозчика (Предварительное оформление заказа)
        Schema::create('invoice_order_customers', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('order_total')->comment('Цена/Выплата за заказ');
            $table->string('description')->nullable();
            $table->string('body_volume')->comment('Общий объём заказа');
            $table->string('type_product')->comment('Тип товара перевозки');

            $table->string('type_transport_weight')->comment('Тип траспортного средства');
            $table->string('type_load_truck')->comment('Тип загрузки трака: LTL, FTL, Custom...');

            $table->uuid('start_address_id')->comment('Адресс начала заказа')
                ->constrained('addresses')->noActionOnDelete();

            $table->uuid('end_address_id')->comment('Адресс доставки')
                ->constrained('addresses')->noActionOnDelete();

            $table->json('cargo_good');

            $table->date('start_date')->comment('Дата отправления');

            $table->date('end_date')->comment('Дата прибытия');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_order_customer');
    }
};
