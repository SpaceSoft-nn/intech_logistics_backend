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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Используем UUID как первичный ключ

            $table->string('password');

            $table->string('first_name')->comment('Имя');
            $table->string('last_name')->comment('Фамилия');
            $table->string('father_name')->comment('Отчество');


            $table->string('role')->comment('Роль User');
            $table->unsignedInteger('permission')->default(0)->comment('Тип доступа');

            $table->boolean('active')->comment('Активен ли пользователь');
            $table->boolean('auth')->unique()->comment('Прошёл ли пользователь нотификацию');

            $table->uuid('personal_area_id')
                ->nullable()
                ->constrained('personal_area', 'id')->noActionOnDelete();

            $table->uuid('email_id')
                ->nullable()
                ->constrained('email_list', 'id')->noActionOnDelete();

            $table->uuid('phone_id')
                ->nullable()
                ->constrained('phone_list', 'id')->noActionOnDelete();


            $table->timestamps();
            $table->rememberToken();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
