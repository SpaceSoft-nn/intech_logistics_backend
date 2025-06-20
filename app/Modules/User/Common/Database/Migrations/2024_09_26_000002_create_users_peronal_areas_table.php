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
        Schema::create('user_personal_area', function (Blueprint $table) {

            $table->uuid('user_id')
                ->constrained('users', 'id')->noActionOnDelete();

            $table->uuid('personal_area_id')
                ->constrained('personal_areas', 'id')->noActionOnDelete();

            $table->unique(['user_id', 'personal_area_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_peronal_areas');
    }
};
