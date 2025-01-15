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
        Schema::create('storekeeper_peoples', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('personal_area_id')
                ->constrained('personal_area', 'id')->noActionOnDelete();

            $table->uuid('individual_people_id')
                ->constrained('individual_peoples', 'id')->noActionOnDelete();

            $table->uuid('organization_id')->nullable()
                ->constrained('organizations', 'id')->noActionOnDelete();


            $table->timestamps();

            $table->unique(['personal_area_id', 'individual_people_id', 'organization_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storekeeper_peoples');
    }
};
