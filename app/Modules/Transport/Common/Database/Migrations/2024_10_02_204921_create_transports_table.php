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
        Schema::create('transports', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('brand_model')->comment('модель - например: Volvo FH, MAN TGS');

            $table->string('type_loading')->comment('Тип загрузки транспортного средства (cбоку, cверху и т.д)');
            $table->string('type_weight')->comment('Тип транспортного средства в Тоннах');
            $table->string('type_body')->comment('Тип Кузова: бортовой, цистерна и т.д');
            $table->string('type_status')->comment('Текущий статус транспортного средства: свободно, эксплуатация, ремонт');


            $table->string('year')->comment('Год выпуска транспорта');
            $table->string('transport_number')->comment('Номерной знак');

            $table->string('body_volume')->comment('Максимальная Вместимость');
            $table->string('body_weight')->comment('Максимальная Масса груза');

            $table->text('description')->nullable()->comment('Описание/Заметка');

            $table->uuid('organization_id')
                ->constrained('organizations', 'id')->noActionOnDelete();

            $table->uuid('driver_id') //1 ко многим у одной машины может быть несколько водителей.
                ->nullable()
                ->constrained('drivers', 'id')->noActionOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
