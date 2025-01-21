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
        Schema::create('organization_order_unit_invoces', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            {
                #TODO Нарушение 3 нормальной формы, транзитивная зависимость, сюда надо добавлять промежуточную таблицу user_organization
                $table->uuid('organization_id') //организация которая откликнулась на заказ
                    ->constrained('organizations')->noActionOnDelete();

                $table->uuid('user_id')
                    ->nullable()
                    ->constrained('user')
                    ->comment('user который создавал данный отклик')
                    ->noActionOnDelete();
            }


            $table->uuid('invoice_order_id')->unique()->comment("Документ при отклике, может быть один связь 1к1")
                ->constrained('invoice_orders')->noActionOnDelete();

            $table->timestamps();

            // Добавляем составной уникальный ключ на order_unit_id и organization_id #todo Тут могут быть проблемы в будущем
            $table->unique(['order_unit_id', 'organization_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_order_unit_invoces');
    }
};
