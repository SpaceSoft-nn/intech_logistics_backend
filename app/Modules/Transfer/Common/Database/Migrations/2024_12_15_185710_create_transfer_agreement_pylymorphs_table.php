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
        Schema::create('transfer_agreement_pylymorphs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('transfer_id')
                ->constrained('transfers')->noActionOnDelete();

            $table->uuid('offer_contractor_invoice_order_customer_id')
                ->constrained('offer_contractor_invoice_order_customers')->noActionOnDelete();

            $table->morphs('agreementable');

            $table->boolean('order_main');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_agreement_pylymorphs');
    }
};
