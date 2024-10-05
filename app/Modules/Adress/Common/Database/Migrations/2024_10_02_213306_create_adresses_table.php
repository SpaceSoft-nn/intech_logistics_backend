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
        Schema::create('adresses', function (Blueprint $table) {
            $table->uuid('id');

            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('building')->nullable();
            $table->string('apartment')->nullable();
            $table->string('house_number')->nullable();
            $table->string('postal_code')->nullable();

            $table->string('type_adress')->nullable();

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses');
    }
};
