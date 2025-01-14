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
        Schema::create('agreement_tenders', function (Blueprint $table) {

            $table->uuid('id')->primary();


            $table->foreignUuid('lot_tender_response_id')->unique() //unique - не может быть множество одинаковых записей на подтврждения - только 1 уникальная
                ->constrained('lot_tender_responses')->noActionOnDelete();

            $table->foreignUuid('organization_contractor_id')->comment('Организация - которая откликнулась на заказ')
                ->constrained('organizations')->noActionOnDelete();

            $table->foreignUuid('lot_tender_id')
                ->constrained('lot_tenders')->noActionOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_tender_accept');
    }
};
