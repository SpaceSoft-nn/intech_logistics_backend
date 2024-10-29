<?php

use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
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
            $table->string('order_status')->default(StatusOrderUnitEnum::draft)->comment('status order');
            $table->string('description')->nullable();
            $table->string('product_type')->nullable()->comment('Тип товара');

            $table->string('type_load_truck')->comment('Тип загрузки трака: LTL, FTL, Custom...');

            $table->uuid('user_id')
                ->nullable()
                ->constrained('users')->noActionOnDelete();

            $table->uuid('mgx_id')->comment('Масса-габаритные характеристики')
                ->nullable()
                ->constrained('mgxs')->noActionOnDelete();

            $table->uuid('organization_id')
                ->constrained('organizations')->noActionOnDelete();

            $table->uuid('contractor_id')->comment('Выбранный подрядчик на заказ.')->nullable()
                ->constrained('organizations')->noActionOnDelete();

                //служебнеы поля
            $table->boolean('add_load_space')->default(false)->comment('Возможен ли догруз');
            $table->boolean('change_price')->default(false)->comment('Возможна изменения цены (торг)');
            $table->boolean('change_time')->default(false)->comment('Возможна Изменение времени');
            $table->boolean('adress_is_array')->comment('Если у нас больше двух адрессов');


            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_units');
    }
};
