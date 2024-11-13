<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus\OrderUnitStatusVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnitStatus;
use Exception;

use function App\Helpers\Mylog;

class OrderUnitStatusCreateAction
{
    public static function make(OrderUnitStatusVO $vo) : OrderUnitStatus
    {
        return self::run($vo);
    }

    /**
     * @param OrderUnitStatosVO $vo
     *
     * @return OrderUnitStatus
     */
    private static function run(OrderUnitStatusVO $vo) : OrderUnitStatus
    {
        #TODO Отлавливать ошибки

        try {

            $orderUnitStatus = OrderUnitStatus::create($vo->toArray());

            return $orderUnitStatus;

        } catch (\Throwable $th) {

            Mylog('Ошибка в OrderUnitStatusCreateAction при создании записи');
            throw new Exception('Ошибка в OrderUnitCreateAction', 500);

        }

        return $order;
    }
}
