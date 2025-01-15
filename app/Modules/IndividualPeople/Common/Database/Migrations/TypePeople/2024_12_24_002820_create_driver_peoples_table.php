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
        Schema::create('driver_peoples', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('personal_area_id')
                ->constrained('personal_area', 'id')->noActionOnDelete();

            $table->uuid('individual_people_id')
                ->constrained('individual_peoples', 'id')->noActionOnDelete();

            $table->uuid('organization_id')->nullable()
                ->constrained('organizations', 'id')->noActionOnDelete();

            $table->string('series')->comment('Серия Водительского Удостоверения');
            $table->string('number')->comment('Номер Водительского Удостоверения');
            $table->date('date_get')->comment('Дата получения Водительского Удостоверения');

            $table->timestamps();

            $table->unique(['personal_area_id', 'individual_people_id', 'organization_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_peoples');
    }
};
