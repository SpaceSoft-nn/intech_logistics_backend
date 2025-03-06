<?php

namespace App\Modules\Tender\Domain\Factories;

use App\Modules\Tender\App\Data\ValueObject\SpecificalDatePeriodVO;
use App\Modules\Tender\Domain\Models\LotTender;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Tender\Domain\Models\SpecificalDatePeriod;


class SpecificalDatePeriodFactory extends Factory
{
    protected $model = SpecificalDatePeriod::class;

    public function definition(): array
    {
        $tender = LotTender::factory()->create();

        /** @var SpecificalDatePeriodVO */
        $specificalDatePeriodVO = SpecificalDatePeriodVO::make(
            lot_tender_id: $tender->id,
            date: '05.05.2022',
            count_transport: $tender->general_count_transport,
        );

        return $specificalDatePeriodVO->toArrayNotNull();
    }


}
