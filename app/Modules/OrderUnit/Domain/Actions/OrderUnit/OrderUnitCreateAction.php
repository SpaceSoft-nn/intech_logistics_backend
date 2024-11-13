<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus\OrderUnitStatusVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus\OrderUnitStatusCreateAction;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Exception;

use function App\Helpers\Mylog;

class OrderUnitCreateAction
{
    public static function make(OrderUnitVO $vo) : ?OrderUnit
    {
        return self::run($vo);
    }

    /**
     * @param OrderUnitVO $vo
     *
     * @return ?OrderUnit
     */
    private static function run(OrderUnitVO $vo) : OrderUnit
    {
        #TODO Отлавливать ошибки

        try {

            $order = OrderUnit::create($vo->toArrayNotNull());

            //Создаём дефолтный статус draft -> черновик
            $status = OrderUnitStatusCreateAction::make(
                OrderUnitStatusVO::make(
                    order_unit_id: $order->id,
                )
            );

        } catch (\Throwable $th) {

            Mylog('Ошибка в OrderUnitCreateAction при создании записи');
            throw new Exception('Ошибка в OrderUnitCreateAction', 500);

        }

        return $order;
    }
}
