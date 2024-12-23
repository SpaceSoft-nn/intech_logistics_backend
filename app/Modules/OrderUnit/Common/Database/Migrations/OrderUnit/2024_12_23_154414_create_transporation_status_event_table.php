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
        Schema::create('transporation_status_events', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('order_unit_id')->comment('ссылка на заказ')
                ->constrained('order_units')->noActionOnDelete();

            $table->foreignId('enum_transporatrion_status_id')->comment('ссылка на таблицу enum/const в бд на статусы')
                ->constrained('enum_transportation_statuses')->noActionOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transporation_status_event');
    }
};
