<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {   //Ссылка на Файлы договора

        Schema::create('agreement_document_tenders', function (Blueprint $table) {

            $table->id('uuid')->primary();

            $table->foreignUuid('lot_tender_id')->unique()
                ->constrained('lot_tenders')->noActionOnDelete();

            $table->string('path')->comment('Указание пути');

            $table->mediumText('description');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_agreement_document');
    }
};
