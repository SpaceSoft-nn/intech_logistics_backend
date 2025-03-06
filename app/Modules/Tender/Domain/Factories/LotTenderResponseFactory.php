<?php

namespace App\Modules\Tender\Domain\Factories;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\App\Data\ValueObject\Response\LotTenderResponseVO;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;
use Illuminate\Database\Eloquent\Factories\Factory;


class LotTenderResponseFactory extends Factory
{
    protected $model = LotTenderResponse::class;

    public function definition(): array
    {
        $tender = LotTender::factory()->create();

        $organization = Organization::factory()->create();

        /** @var LotTenderResponseVO */
        $vo = LotTenderResponseVO::make(
            lot_tender_id: $tender->id,
            organization_contractor_id: $organization->id,
        );

        return $vo->toArrayNotNull();
    }


}
