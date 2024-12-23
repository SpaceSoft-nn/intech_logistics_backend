<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\Status\TransporationStatusVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus;
use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransporationStatusFactory extends Factory
{
    protected $model = TransporationStatus::class;

    public function definition(): array
    {
        $order = OrderUnit::first();

        $status = EnumTransportationStatus::find($this->faker->numberBetween(1,3));


        $chainStatus = TransporationStatusVO::make(
            order_unit_id: $order->id,
            enum_transporatrion_status_id: $status->id,
        );


        return $chainStatus->toArrayNotNull();
    }

}


