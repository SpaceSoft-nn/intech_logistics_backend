<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {   //Ссылка на файлы приложения
        Schema::create('application_document_tenders', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('lot_tender_id')
                ->constrained('lot_tenders')->noActionOnDelete();

            $table->string('path')->unique()->comment('Указание пути к файлу');

            #TODO Когда-нибудь понадобится
            // $table->string('original_name');
            // $table->string('unique_name')->unique();


            $table->string('disk')->default('tender_documents')->comment('Диск хранения файла');

            $table->mediumText('description')->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('storage_application_document');
    }
};
