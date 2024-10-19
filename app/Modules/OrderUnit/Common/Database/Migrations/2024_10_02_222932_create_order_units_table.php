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

            $table->date('end_date_order')->nullable()->comment('До какой даты заказ будет активен');

            $table->string('body_volume')->comment('Общий объём заказа');

            $table->string('order_total')->comment('Цена/Выплата за заказ');
            $table->string('description');
            $table->string('product_type')->nullable()->comment('Тип товара');

            // $table->string('order_status')->nullable()->comment('Заказ: в ожидании, в процессе, в обработке, удален, выполнен');

            $table->uuid('mgx_id')->unique()->constrained('mgxs')->onDelete('cascade')->comment('Ссылку на таблицу с Массо-габаритными-характеристиками');

            $table->uuid('user_id')
                ->nullable()
                ->constrained('users')->noActionOnDelete();

            $table->uuid('organization_id')
                ->constrained('organizations')->noActionOnDelete();

            $table->boolean('add_load_space')->default(false)->comment('Возможен ли догруз');
            $table->boolean('change_price')->default(false)->comment('Возможна изменения цены (торг)');
            $table->boolean('change_time')->default(false)->comment('Возможна Изменение времени');


            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_units');
    }
};
