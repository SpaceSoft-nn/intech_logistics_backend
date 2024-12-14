<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        // Таблица - Когда перевозчик выбрал заказчика (отклик заказчика)
        Schema::create('agreement_order_contractors', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('offer_contractor_invoice_order_customer_id')->unique() #TODO - Возможно надо будет убирать unique
                ->constrained('offer_contractor_invoice_order_customers')->noActionOnDelete();

            $table->uuid('order_unit_id')->comment('Создание заказа после согласование сторон')->nullable()
                ->constrained('order_units')->noActionOnDelete();

            {   #TODO Нужно заменять на таблицу user_organization для 3NF нормальной формы

                $table->uuid('organization_contractor_id')->comment('Организация перевозчика')
                    ->constrained('organizations')->noActionOnDelete();


                $table->uuid('user_id')->nullable()
                    ->constrained('users')->noActionOnDelete();
            }

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('agreement_order_contractor');
    }
};
