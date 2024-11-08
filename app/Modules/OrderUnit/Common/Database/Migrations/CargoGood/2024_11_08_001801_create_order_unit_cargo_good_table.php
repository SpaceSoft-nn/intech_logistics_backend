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
        Schema::create('order_unit_cargo_good', function (Blueprint $table) {

            $table->id('id');

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            $table->uuid('cargo_good_id')
                ->constrained('cargo_goods')->noActionOnDelete();

            $table->primary(['order_unit_id', 'cargo_good_id']);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_unit_cargo_good');
    }
};
