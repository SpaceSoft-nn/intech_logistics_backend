<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
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

        $order = OrderUnit::create($vo->toArrayNotNull());

        dd($order);

        try {


            $order = OrderUnit::create($vo->toArrayNotNull());

            dd($order);

        } catch (\Throwable $th) {

            Mylog('Ошибка в OrderUnitCreateAction при создании записи');
            throw new Exception('Ошибка в OrderUnitCreateAction', 500);

        }

        return $order;
    }
}
