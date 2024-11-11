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
        Schema::create('order_unit_cargo_good', function (Blueprint $table) {

            $table->id('id');

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            $table->uuid('cargo_good_id')
                ->constrained('cargo_goods')->noActionOnDelete();

            $table->primary(['order_unit_id', 'cargo_good_id']);

            $table->timestamps(); // не будет работать

        });

        //Создание функции для триггера goods_is_array
        DB::unprepared(
            "CREATE OR REPLACE FUNCTION update_goods_is_array() RETURNS TRIGGER AS $$
            BEGIN
                IF (SELECT COUNT(*) FROM order_unit_cargo_good WHERE order_unit_id = COALESCE(NEW.order_unit_id, OLD.order_unit_id) ) > 1 THEN
                    UPDATE order_units
                    SET goods_is_array = TRUE
                    WHERE id = NEW.order_unit_id;
                ELSE
                    UPDATE order_units
                    SET goods_is_array = FALSE
                    WHERE id = NEW.order_unit_id;
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;"
        );

        // Создание триггера для изменение goods_is_array
        DB::unprepared(
            "CREATE TRIGGER update_goods_is_array_trigger
            AFTER INSERT OR UPDATE OR DELETE ON order_unit_cargo_good
            FOR EACH ROW
            EXECUTE FUNCTION update_goods_is_array();"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_unit_cargo_good');
    }
};
