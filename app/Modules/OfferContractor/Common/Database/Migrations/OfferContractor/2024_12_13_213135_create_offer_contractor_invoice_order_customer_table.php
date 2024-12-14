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
        // Откликнувшиеся Заказчики на предложения перевозчиков
        Schema::create('offer_contractor_invoice_order_customers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('invoice_order_customer_id')->unique() #TODO возможно unique нужно будет убирать, т.к нужно будет использовать эту информацию как черновик для других откликов
                ->constrained('invoice_order_customers')->noActionOnDelete();

            $table->uuid('offer_contractor_id')
                ->constrained('offer_contractors')->noActionOnDelete();

            {   #TODO Нужно заменять на таблицу user_organization для 3NF нормальной формы

                $table->uuid('organization_id')
                    ->constrained('organizations')->noActionOnDelete();

                $table->uuid('user_id')->nullable()
                    ->constrained('users')->noActionOnDelete();
            }



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_contractor_invoice_order_customer');
    }
};
