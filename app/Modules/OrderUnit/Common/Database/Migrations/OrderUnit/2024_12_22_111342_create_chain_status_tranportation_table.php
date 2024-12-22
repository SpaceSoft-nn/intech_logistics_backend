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
        Schema::create('chain_status_tranportation', function (Blueprint $table) {
            $table->id();

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            $table->id('from_status_id')->comment('Статус явный (настоящий)')
                ->constrained('enum_transportation_statuses')->noActionOnDelete();

            $table->id('to_status_id')->comment('Следующий статус в цепочке')
                ->constrained('enum_transportation_statuses')->noActionOnDelete();

            $table->string('comment')->nullable();

            $table->boolean('active_status')->comment('Активный статус у определённого заказа в данный момент');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chain_status_tranportation');
    }
};
