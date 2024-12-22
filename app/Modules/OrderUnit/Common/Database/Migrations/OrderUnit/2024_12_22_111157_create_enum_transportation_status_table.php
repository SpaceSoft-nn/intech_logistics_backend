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
        Schema::create('enum_transportation_statuses', function (Blueprint $table) {
            $table->id('id')->primary();

            $table->string('enum_name')->comment('Название статуса');
            $table->string('enum_value')->comment('Значения Статуса');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enum_transportation_status');
    }
};
