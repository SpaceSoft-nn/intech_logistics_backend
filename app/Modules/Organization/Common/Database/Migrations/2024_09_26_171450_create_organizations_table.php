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
        Schema::create('organizations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('owner_id')
                ->nullable()
                ->constrained('users')->noActionOnDelete();

            $table->string('name');
            $table->string('address');

            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->boolean('remuved')->default(false)->comment('Статус Закрыт/Открыт');
            $table->string('website')->nullable();
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('industry');
            $table->dateTime('founded_date');

            $table->string('inn', 12)->unique()->comment('Инн у ООО/ИП');
            $table->string('kpp' , 9)->nullable()->comment('КПП - Только у организации');
            $table->string('registration_number', 13)->nullable()->unique()->comment('ОГРН - Только у организации');
            $table->string('registration_number_individual', 15)->nullable()->unique()->comment('ОГРНИП - Только у ИП');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
