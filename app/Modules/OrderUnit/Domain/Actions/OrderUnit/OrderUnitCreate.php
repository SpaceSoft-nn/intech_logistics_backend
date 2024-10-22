<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;

class OrderUnitCreate
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
    private static function run(OrderUnitVO $vo) : ?OrderUnit
    {

        #TODO Отлавливать ошибки

        $order = OrderUnit::create($vo->toArrayNotNull());

        return $order;
    }
}
