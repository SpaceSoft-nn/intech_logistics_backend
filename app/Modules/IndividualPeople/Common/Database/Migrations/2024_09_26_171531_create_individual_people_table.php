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
        Schema::create('individual_peoples', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();

            $table->string('first_name')->comment('Имя');
            $table->string('last_name')->comment('Фамилия');
            $table->string('father_name')->comment('Отчество');

            $table->string('position');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('other_contact');
            $table->string('comment')->nullable();
            $table->string('remuved')->default(false)->comment('Статус удаление');

            $table->uuid('personal_area_id')
                ->constrained('personal_area', 'id')->noActionOnDelete();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('individual_people');
    }
};
