<?php

use App\Modules\Base\Enums\WeekEnums;
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
        Schema::create('week_periods', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('lot_tender_id')->unique()
                ->constrained('lot_tenders')->noActionOnDelete();

            $table->enum('value', [
                WeekEnums::monday,
                WeekEnums::tuesday,
                WeekEnums::wednesday,
                WeekEnums::thursday,
                WeekEnums::friday,
                WeekEnums::saturday,
                WeekEnums::sunday,
            ]);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('week_periods');
    }
};
