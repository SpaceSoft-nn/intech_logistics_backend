<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_units', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->bigIncrements('number_order')->comment('Номер заказа для фронта')->index('number');

            $table->date('end_date_order')->nullable()->comment('До какой даты заказ будет активен');
            $table->date('exemplary_date_start')->nullable()->comment('Примерная дата начала заказ');

            $table->string('body_volume')->nullable()->comment('Общий объём заказа'); #TODO убрать ->nullable()

            $table->string('order_total')->comment('Цена/Выплата за заказ');
            $table->string('description')->nullable();


            $table->string('type_transport_weight')->comment('Тип траспортного средства');


            //unsignedSmallInteger - будел ли проблема с этим типом?
            $table->unsignedSmallInteger('cargo_unit_sum')->nullable()->comment('Общее количество паллетов в заказе'); #TODO убрать ->nullable()


            $table->string('type_load_truck')->comment('Тип загрузки трака: LTL, FTL, Custom...');

            //Связи
            $table->uuid('user_id')->comment('Пользователь создавший заказ, если nullable - то заказ создался автоматически от согласования tender')
                ->nullable()
                ->constrained('users')->noActionOnDelete();

            $table->uuid('organization_id')->comment('Организация к которой привязан заказ')
                ->constrained('organizations')->noActionOnDelete();

            $table->uuid('contractor_id')->comment('Выбранный подрядчик на заказ.')->nullable()
                ->constrained('organizations')->noActionOnDelete();

            $table->uuid('transport_id')->comment('Выбранный транспорта перевозчика')->nullable()
                ->constrained('transports')->noActionOnDelete();

            $table->uuid('offer_contractor_id')->comment("Ссылка на предложения перевозчика, заказ создаётся от логики 'предложения перевозчика' ")->nullable()
                ->constrained('offer_contractors')->noActionOnDelete();


                //служебнеы поля
            $table->boolean('add_load_space')->default(false)->comment('Возможен ли догруз');
            $table->boolean('change_price')->default(false)->comment('Возможна изменения цены (торг)');
            $table->boolean('change_time')->default(false)->comment('Возможна Изменение времени');

            $table->boolean('address_is_array')->default(false)->comment('Если у нас больше двух адрессов');
            $table->boolean('goods_is_array')->default(false)->comment('Если у заказа больше одного груза');

            $table->timestamps();

        });


    }

    public function down(): void
    {
        Schema::dropIfExists('order_units');
    }
};
