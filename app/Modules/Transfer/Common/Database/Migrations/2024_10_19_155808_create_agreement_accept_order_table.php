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
        Schema::create('agreement_orders_accepts', function (Blueprint $table) {

            $table->uuid('id');

            $table->nullableMorphs('document_agreement_accept_order');

            $table->uuid('agreement_order_id')->unique()
                ->constrained('agreement_orders')->noActionOnDelete();

            $table->boolean('order_bool')->comment('Заказчик подтвердил');
            $table->boolean('executor_bool')->comment('Исполнитель подтвердил');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_accept_order');
    }
};
