<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        //когда исполнитель выбран заказчиком
        Schema::create('agreement_orders', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('order_unit_id')->unique()
                ->constrained('order_units')->noActionOnDelete();

            $table->uuid('organization_contractor_id')->nullable()->comment('Данные организации contractor (подрядчика)')
                ->constrained('transfers')->noActionOnDelete();

            $table->uuid('organization_order_units_invoce_id')->unique()
                ->constrained('organization_order_unit_invoces')->noActionOnDelete();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreement_order');
    }
};
