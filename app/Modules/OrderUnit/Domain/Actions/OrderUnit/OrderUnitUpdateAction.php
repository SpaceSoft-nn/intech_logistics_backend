<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitUpdateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus\OrderUnitStatusVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus\OrderUnitStatusCreateAction;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;

class OrderUnitUpdateAction
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

        $order = DB::transaction(function ($pdo) use ($dto) {

            /**
            * @var OrderUnit
            */
            $order = $dto->order;

            if(!is_null($dto->change_price)) { $order->change_price = $dto->change_price; }
            if(!is_null($dto->change_time)) { $order->change_time = $dto->change_time; }


            { //Создаём новый статус и привязываем его


                /**
                 * @var OrderUnitStatusVO
                 */
                $orderUnitStatusVO = OrderUnitStatusVO::make(
                    order_unit_id: $order->id,
                    status: $dto->order_status->getNameCase(),
                );

                $t = OrderUnitStatusCreateAction::make($orderUnitStatusVO);
            }


            return $order;

        });



        return $order->save();
    }
}
