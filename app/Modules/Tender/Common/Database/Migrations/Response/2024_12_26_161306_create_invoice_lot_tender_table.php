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
        Schema::create('invoice_lot_tenders', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('transport_id')
                ->constrained('transports')->noActionOnDelete();

            $table->foreignUuid('lot_tender_response_id')->unique()
                ->constrained('lot_tender_responses')->noActionOnDelete();

            $table->double('price_for_km')->comment('количество транспорта');

            $table->mediumText('comment')->nullable()->comment('количество транспорта');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_lot_tender');
    }
};
