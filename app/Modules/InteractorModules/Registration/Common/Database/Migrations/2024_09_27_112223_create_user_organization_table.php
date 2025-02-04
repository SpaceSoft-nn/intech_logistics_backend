<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_organization', function (Blueprint $table) {

            $table->id('id')->primary();

            $table->uuid('user_id')
                ->constrained('users', 'id')->noActionOnDelete();

            $table->uuid('organization_id')
                ->constrained('organizations', 'id')->noActionOnDelete();

            #TODO Нужно указать явно что создавать - а не nullable
            $table->string('type_cabinet')->nullable()->comment('Тип кабинета: заказчик, склад (РЦ), перевозчик');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_organization');
    }
};

