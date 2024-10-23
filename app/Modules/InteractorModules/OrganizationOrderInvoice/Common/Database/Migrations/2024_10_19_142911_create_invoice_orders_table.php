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
        Schema::create('invoice_orders', function (Blueprint $table) {

            $table->uuid('id');

            //Нужно ли?
            // $table->uuid('organization_id')
            //     ->constrained('organizations')->noActionOnDelete();

            $table->string('price');

            $table->date('date');

            $table->text('comment');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_orders');
    }
};
