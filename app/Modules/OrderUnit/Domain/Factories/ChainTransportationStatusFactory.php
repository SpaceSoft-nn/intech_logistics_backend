<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\Status\ChainTransportationStatusVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Models\Status\ChainTransportationStatus;
use App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChainTransportationStatusFactory extends Factory
{
    protected $model = ChainTransportationStatus::class;

    public function definition(): array
    {

        $order = OrderUnit::first();

        $status = EnumTransportationStatus::find($this->faker->numberBetween(1,3));

        $chainStatus = ChainTransportationStatusVO::make(
            order_unit_id: $order->id,
            from_status_id: $status->id,
            to_status_id: $status->id,
            active_status: false,
            comment: 'Тестовый комментарий',
        );


        return $chainStatus->toArrayNotNull();
    }

}


