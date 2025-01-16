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
        Schema::create('avizo_phones', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('sender')->comment('Отправитель');
            $table->string('confirming')->comment('Подтверждающий');


            // $table->boolean('status_sender')->default(true)->comment('Статус подтверждения со стороны отправителя'); //иницаитор отправления, всегда должен быть bool в подтверждении статуса
            $table->boolean('status_confirmation')->default(false)->comment('Статус подтверждения со стороны подтверждающего');

            $table->string('code')->index()->comment('Код для подтврждения');
            $table->string('code_liftime')->comment('Время жизни кода');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avizos');
    }
};
