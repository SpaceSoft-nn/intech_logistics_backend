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
        Schema::create('lot_tender_responses', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('lot_tender_id')
                ->constrained('lot_tenders')->noActionOnDelete();

            $table->foreignUuid('organization_contractor_id')->comment('Организация - перевозчика, которая откликнулась на тендер')
                ->constrained('organizations')->noActionOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
