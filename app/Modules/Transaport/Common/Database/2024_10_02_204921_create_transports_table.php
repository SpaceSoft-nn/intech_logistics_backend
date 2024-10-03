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

            $table->uuid('id');

            $table->string('type')->comment("Тип транспортного средства: грузовик, фуру, легковое, контейнерный ");
            $table->string('brand_model')->comment('Марка и модель - например: Volvo FH, MAN TGS');
            $table->string('year')->comment('Год выпуска транспорта');
            $table->string('transport_number')->comment('Номерной знак');
            $table->string('body_volume')->comment('Максимальная Вместимость');
            $table->string('body_weight')->comment('Максимальная Масса груза');
            $table->string('type_status')->comment('Текущий статус транспортного средства: свободно, эксплуатация, ремонт');
            $table->text('description')->comment('Описание/Заметка');

            $table->uuid('organization_id')
                ->constrained('organizations', 'id')->noActionOnDelete();

            $table->uuid('driver_id')
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
