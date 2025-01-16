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
        Schema::create('avizo_emails', function (Blueprint $table) {
            $table->id();

            $table->string('sender')->comment('Отправитель подтверждения');
            $table->string('confirming')->comment('Подтверждающий');

            $table->string('sender')->comment('Отправитель');
            $table->string('confirming')->comment('Подтверждающий');

            $table->boolean('status_sender')->comment('Статус подтверждения со стороны отправителя');
            $table->boolean('status_confirming')->comment('Статус подтверждения со стороны подтверждающего');

            $table->string('url')->comment('Url для подтверждения');
            $table->string('code_liftime')->comment('Время жизни кода');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avizo_emails');
    }
};
