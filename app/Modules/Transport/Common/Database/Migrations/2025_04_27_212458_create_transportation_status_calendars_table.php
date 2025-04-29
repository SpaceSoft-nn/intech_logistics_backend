<?php
namespace App\Modules\Transport\Common\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transportation_status_calendars', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->date('date');

            $table->foreignUuid('order_unit_id')
                ->index()
                ->constrained('order_units', 'id')->noActionOnDelete();

            $table->foreignId('enum_transportation_id')
                ->index()
                ->constrained('enum_transportation_statuses', 'id')->noActionOnDelete();

            $table->foreignUuid('transport_id')
                ->index()
                ->constrained('transports', 'id')->noActionOnDelete();

            $table->foreignUuid('address_id')
                ->index()
                ->constrained('addresses', 'id')->noActionOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transporation_status_calendars');
    }
};
