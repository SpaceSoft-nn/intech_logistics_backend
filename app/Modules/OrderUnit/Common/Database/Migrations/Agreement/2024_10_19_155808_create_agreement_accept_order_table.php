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

            $table->uuid('id')->primary();

            $table->nullableMorphs('document_agreement_accept_order');

            $table->uuid('agreement_order_id')->unique()
                ->constrained('agreement_orders')->noActionOnDelete();

            $table->boolean('order_bool')->default(false)->comment('Заказчик подтвердил');
            $table->boolean('contractor_bool')->default(false)->comment('Исполнитель подтвердил');
            $table->boolean('one_agreement')->default(false)->comment('Если вдруг исполнитель/заказчик не находится в нашей инфрастуктуре (внешний апи), тогда нужно что бы было подтвреждение с одной стороны');

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
