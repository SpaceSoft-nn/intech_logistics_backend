<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {   //Ссылка на файлы приложения
        Schema::create('application_document_tenders', function (Blueprint $table) {

            $table->id('uuid')->primary();

            $table->foreignUuid('lot_tender_id')
                ->constrained('lot_tenders')->noActionOnDelete();

            $table->string('path')->comment('Указание пути к файлу');

            $table->string('value')->comment('Значение файла пример: мед книжка');

            $table->mediumText('description');

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('storage_application_document');
    }
};
