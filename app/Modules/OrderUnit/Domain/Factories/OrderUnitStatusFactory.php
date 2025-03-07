<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus\OrderUnitStatusVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnitStatus;
use App\Modules\Organization\Domain\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderUnitStatusFactory extends Factory
{
    protected $model = OrderUnitStatus::class;

    public function definition(): array
    {
        /**
        * @var Organization
        */
        $orderUnit = OrderUnit::factory()->create();

        {
            $statusVO = OrderUnitStatusVO::make(
                order_unit_id: $orderUnit->id,
            );

            return $statusVO->toArray();
        }

    }

}
