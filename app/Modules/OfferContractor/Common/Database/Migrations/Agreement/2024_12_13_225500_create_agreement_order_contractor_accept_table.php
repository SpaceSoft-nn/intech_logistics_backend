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
        Schema::create('agreement_order_contractor_accept', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('agreement_order_contractor_id')
                ->constrained('agreement_order_contractors')->noActionOnDelete();

            $table->boolean('order_bool')->comment('Подтврждения со стороны организации: заказчика');
            $table->boolean('contractor_bool')->comment('Подтврждения со стороны организации: перевозчика');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_order_contractor_accept');
    }
};
