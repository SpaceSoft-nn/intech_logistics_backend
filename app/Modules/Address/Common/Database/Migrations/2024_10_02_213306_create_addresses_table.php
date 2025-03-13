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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('building')->nullable();
            $table->string('postal_code')->nullable();

            $table->string('nomination')->nullable()->comment('Наименование Адресса, может указать сам пользователь');

            // $table->string('type_address')->nullable();

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->json('json')->nullable();
            $table->date('update_json')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
