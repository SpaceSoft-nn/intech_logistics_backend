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
        Schema::create('transfers', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('transport_id')
                ->constrained('transports')->noActionOnDelete();

            $table->date('delivery_start')->comment('Дата загрузки и отправления');
            $table->date('delivery_end')->comment('Дата прибытия');

            $table->uuid('address_start_id')
                ->constrained('addresses')->noActionOnDelete();

            $table->uuid('address_end_id')
                ->constrained('addresses')->noActionOnDelete();

            $table->string('order_total')->comment('Общая сумма всех заказов');

            $table->text('description');
            $table->string('body_volume')->comment('Подсчет общего объёма загрузки');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
