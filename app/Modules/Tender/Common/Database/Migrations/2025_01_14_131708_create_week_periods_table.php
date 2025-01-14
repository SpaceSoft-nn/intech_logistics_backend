<?php

use App\Modules\Base\Enums\WeekEnum;
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

            $table->foreignUuid('lot_tender_id')
                ->constrained('lot_tenders')->noActionOnDelete();

            $table->enum('value', [
                WeekEnum::monday->value,
                WeekEnum::tuesday->value,
                WeekEnum::wednesday->value,
                WeekEnum::thursday->value,
                WeekEnum::friday->value,
                WeekEnum::saturday->value,
                WeekEnum::sunday->value,
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
