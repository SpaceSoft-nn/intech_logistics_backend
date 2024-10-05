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
        Schema::create('cargo_unit_transfer', function (Blueprint $table) {


            $table->uuid('cargo_unit_id')
                ->constrained('cargo_units')->noActionOnDelete();

            $table->uuid('transfer_id')
                ->constrained('transafers')->noActionOnDelete();

            $table->primary(['cargo_unit_id', 'transfer_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_unit_transfer');
    }
};
