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
        //когда исполнитель выбран заказчиком
        Schema::create('agreement_orders', function (Blueprint $table) {

            $table->uuid('id');


            $table->uuid('organization_transfer_id')->nullable()->comment('Пока стороны не заключили договор двухсторонний, transfer не будет создан')
                ->constrained('transfers')->noActionOnDelete();

            $table->uuid('organization_order_units_invoce')->unique()
                ->constrained('organization_order_unit_invoces')->noActionOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_order');
    }
};
