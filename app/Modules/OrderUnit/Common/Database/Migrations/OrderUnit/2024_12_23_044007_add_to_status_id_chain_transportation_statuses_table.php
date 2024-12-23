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
         //Делается для того что бы БД уже создало запись, и у указывала на эту же таблицу
        Schema::table('chain_transportation_statuses', function (Blueprint $table) {
            $table->foreignUuid('to_status_id')
                ->nullable()
                ->comment('Следующий статус в цепочке (ссылка на следующую запись в этой же таблице)')
                ->after('comment')
                ->constrained('chain_transportation_statuses')
                ->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chain_transportation_statuses', function (Blueprint $table) {
            // Удаляем внешние ключи перед удалением таблицы
            $table->dropForeign(['to_status_id']);
        });
    }
};
