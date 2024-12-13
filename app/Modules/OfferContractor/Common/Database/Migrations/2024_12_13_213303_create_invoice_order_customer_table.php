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
        Schema::create('invoice_order_customer', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('order_total')->comment('Цена/Выплата за заказ');
            $table->string('description')->nullable();
            $table->string('body_volume')->nullable()->comment('Общий объём заказа'); #TODO убрать ->nullable()
            $table->string('type_transport_weight')->comment('Тип траспортного средства');
            $table->string('type_load_truck')->comment('Тип загрузки трака: LTL, FTL, Custom...');

            $table->uuid('start_address_id')->comment('Адресс начала заказа')
                ->nullable()
                ->constrained('addresses')->noActionOnDelete();

            $table->uuid('end_address_id')->comment('Адресс доставки')
                ->nullable()
                ->constrained('addresses')->noActionOnDelete();

            $table->date('start_date: uuid');

            $table->date('end_date: uuid');


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
