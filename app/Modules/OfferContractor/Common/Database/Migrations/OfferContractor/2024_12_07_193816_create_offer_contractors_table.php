<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Предложения от перевозчиков (какого числа и откуда могут перевести грузы)
    public function up(): void
    {
        // Предложения от перевозчиков
        Schema::create('offer_contractors', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->bigIncrements('number')->comment('Номер предложения для фронта')->index('number_offer_contractor');

            $table->string('city_name_start')->comment('Только город');
            $table->string('city_name_end')->comment('Только город');

            $table->string('price_for_distance')->comment('Дистанция за 1 км');

            $table->string('description')->comment('Дистанция за 1 км')->nullable();

            $table->string('status')->default('draft');

            $table->uuid('transport_id')->constrained('transports');
            $table->uuid('user_id')->constrained('users')->nullable();
            $table->uuid('organization_id')->constrained('organizations');
            $table->uuid('order_unit_id')->constrained('order_units')->nullable()->comment('к какому заказу привязано предложения'); #TODO Подумать нужно ли это указывать?

            $table->boolean('add_load_space')->default(false)->comment('Возможен ли догруз');
            $table->boolean('road_back')->default(false)->comment('Обратная дорога');
            $table->boolean('directly_road')->default(false)->comment('Прямая дорога');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_contractors');
    }
};
