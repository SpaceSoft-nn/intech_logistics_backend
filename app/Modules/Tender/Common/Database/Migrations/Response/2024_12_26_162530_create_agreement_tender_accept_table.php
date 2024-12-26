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
        Schema::create('agreement_tender_accepts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('agreement_tender_id')
                ->constrained('agreement_tenders')->noActionOnDelete();

            $table->boolean('tender_creater_bool')->default(false)->comment('Статус организации: создателя тендера');
            $table->boolean('contractor_bool')->default(false)->comment('Статус организации: откликнувшиеся на тендер');

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
