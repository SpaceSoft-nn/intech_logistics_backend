<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitUpdateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;

class OrderUnitUpdate
{
    public static function make(OrderUnitUpdateDTO $dto) : bool
    {
        return self::run($dto);
    }

    /**
     * @param OrderUnitVO $vo
     *
     * @return bool
     */
    private static function run(OrderUnitUpdateDTO $dto) : bool
    {

        /**
        * @var OrderUnit
        */
        $order = $dto->order;

        $order->change_price = $dto->change_price;
        $order->change_time = $dto->change_time;
        $order->order_status = $dto->order_status;

        return $order->save();
    }
}
