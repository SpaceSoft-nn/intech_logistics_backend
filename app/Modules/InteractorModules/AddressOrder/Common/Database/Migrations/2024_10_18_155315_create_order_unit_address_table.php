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
        Schema::create('order_unit_address', function (Blueprint $table) {

            $table->id('id')->primary();

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            $table->uuid('address_id')
                ->constrained('addresses')->noActionOnDelete();

            $table->date('data_time');

            $table->string('type');

            $table->integer('priority')->default(null)->comment('Приоритетность - с помощью этого поля поймём вектор движение между адрессами');

            $table->timestamps();

            // Здесь мы создаем составной уникальный ключ
            $table->unique(['order_unit_id', 'address_id']);
        });

        DB::unprepared(
            "CREATE OR REPLACE FUNCTION update_address_is_array()
            RETURNS TRIGGER AS $$
            BEGIN
                IF (SELECT COUNT(*) FROM order_unit_address WHERE order_unit_id = COALESCE(NEW.order_unit_id, OLD.order_unit_id) ) > 1 THEN
                    UPDATE order_units
                    SET address_is_array = TRUE
                    WHERE id = NEW.order_unit_id;
                ELSE
                    UPDATE order_units
                    SET address_is_array = FALSE
                    WHERE id = NEW.order_unit_id;
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;"
        );


        // Создание триггера для изменение address_is_array
        DB::unprepared(
            "CREATE TRIGGER update_address_is_array_trigger
            AFTER INSERT OR UPDATE OR DELETE ON order_unit_address
            FOR EACH ROW
            EXECUTE FUNCTION update_address_is_array();"
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_unit_address');
    }
};
