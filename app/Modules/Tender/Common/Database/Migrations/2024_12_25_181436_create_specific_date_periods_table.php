<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {   //Конкретные даты выполнения тендера -> заказа
        Schema::create('specific_date_periods', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('lot_tender_id')->comment('Выбранный подрядчик на заказ.')
                ->constrained('lot_tenders')->noActionOnDelete();

            $table->date('date')->comment('Дата выполнения');

            $table->unsignedSmallInteger('count_transport')->comment('Количество транспорта');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specific_date_periods');
    }
};
