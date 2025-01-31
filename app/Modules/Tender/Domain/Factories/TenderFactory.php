<?php

namespace App\Modules\Tender\Domain\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Tender\App\Data\Enums\TypeTenderEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\Tender\Domain\Models\LotTender;

class TenderFactory extends Factory
{
    protected $model = LotTender::class;

    public function definition(): array
    {
        $typeTransportWeight = TypeTransportWeight::cases();
        $typeTransportWeight = $this->faker->randomElement($typeTransportWeight);

        $typeLoadingTruckMethod = TypeLoadingTruckMethod::cases();
        $typeLoadingTruckMethod = $this->faker->randomElement($typeLoadingTruckMethod);

        $typeTenderEnum = TypeTenderEnum::cases();
        $typeTenderEnum = $this->faker->randomElement($typeTenderEnum);


        $tender = LotTenderVO::make(
            general_count_transport: $this->faker->numberBetween(1, 15),
            price_for_km: $this->faker->numberBetween(50, 180),
            body_volume_for_order: $this->faker->numberBetween(4, 25),
            type_transport_weight: $typeTransportWeight->name,
            type_load_truck: $typeLoadingTruckMethod->name,
            type_tender: $typeTenderEnum->name,
            date_start: now(),
            period: 5,
            organization_id: Organization::factory()->create()->id,
            status_tender: StatusTenderEnum::published,
        );

        $tender = $tender->toArrayNotNull();


        return $tender;
    }


}
