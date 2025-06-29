<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('passports', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('first_name')->comment('Имя');
            $table->string('last_name')->comment('Фамилия');
            $table->string('father_name')->comment('Отчество');


            $table->string('passport_series', 4)->comment('Серия');
            $table->string('passport_number', 6)->comment('Номер');
            $table->date('issue_date')->comment('Когда выдан');
            $table->date('birth_day')->comment('Дата Рождения');
            $table->string('issued_by')->comment('Кем выдан');
            $table->string('department_code', 7)->nullable()->comment('Код подразделения в формате XXX-XXX (7 символов с включённым дефисом)');

            $table->uuid('individual_people_id')->unique()
                ->constrained('individual_peoples', 'id')->noActionOnDelete();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passports');
    }
};
