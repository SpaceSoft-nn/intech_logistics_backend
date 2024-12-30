<?php
namespace App\Modules\OrderUnit\Common\Database\Migrations\OrderUnit;

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
        Schema::table('order_units', function (Blueprint $table) {


            $table->foreignUuid('lot_tender_id')->comment('Если заказ создатёся по бизнес-логики Тендера')->nullable()
                ->constrained('lot_tenders')->noActionOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_units', function (Blueprint $table) {

            $table->dropColumn('lot_tender_id');

        });
    }
};
