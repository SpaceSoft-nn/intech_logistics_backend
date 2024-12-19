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
        //Событие транспортировки: в пути, на выгрзке, на разгрузке
        Schema::create('transportating_event_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            $table->string('status')->comment('Событие транспортировки: в пути, на выгрзке, на разгрузке');

            $table->timestamps(3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_events');
    }
};
