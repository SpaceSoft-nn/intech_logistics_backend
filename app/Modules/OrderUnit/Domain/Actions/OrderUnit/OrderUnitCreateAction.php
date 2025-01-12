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

        try {

            $order = OrderUnit::create($vo->toArrayNotNull());

            #TODO Мы здесь создаём статус, нужно ли эту логику переносить как триггер?
            //Создание статуса
            if(!is_null($vo->order_status)) {

                $status = OrderUnitStatusCreateAction::make(
                    OrderUnitStatusVO::make(
                        order_unit_id: $order->id,
                        status: $vo->order_status->value,
                    )
                );

            } else {

                //Создаём дефолтный статус draft -> черновик
                $status = OrderUnitStatusCreateAction::make(
                    OrderUnitStatusVO::make(
                        order_unit_id: $order->id,
                    )
                );

            }



        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $order;
    }
}
