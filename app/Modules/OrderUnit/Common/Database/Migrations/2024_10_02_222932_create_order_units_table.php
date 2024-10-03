<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_units', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->date('delivery_start');
            $table->date('delivery_end');

            $table->uuid('adress_start_id')
                ->constrained('adresses')->noActionOnDelete();

            $table->uuid('adress_end_id')
                ->constrained('adresses')->noActionOnDelete();


            $table->string('body_volume')->comment('Общий объём заказа');

            $table->string('order_total')->comment('Цена/Выплата за заказ');
            $table->string('description');
            $table->string('product_type')->nullable()->comment('Тип товара');
            $table->string('order_status')->nullable()->comment('Заказ: в ожидании, в процессе, в обработке, удален, выполнен');

            $table->uuid('user_id')
                ->nullable()
                ->constrained('users')->noActionOnDelete();

            $table->uuid('organization_id')
                ->constrained('organizations')->noActionOnDelete();


            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_units');
    }
};
