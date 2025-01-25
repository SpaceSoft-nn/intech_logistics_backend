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

            $table->string('position')->nullable();
            $table->string('phone')->uniqid()->nullable(); #TODO - должен быть уканильный?
            $table->string('email')->uniqid()->nullable(); #TODO - должен быть уканильный?
            $table->string('other_contact')->nullable();
            $table->mediumText('comment')->nullable();
            $table->string('remuved')->default(false)->comment('Статус удаление');

            $table->uuid('individualable_id')->nullable();
            $table->string('individualable_type')->nullable();


                $table->foreignUuid('personal_area_id')
                    ->constrained('personal_areas', 'id')->noActionOnDelete();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('individual_people');
    }
};
