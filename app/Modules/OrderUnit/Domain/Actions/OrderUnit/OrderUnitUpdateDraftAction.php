<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitUpdateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus\OrderUnitStatusVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus\OrderUnitStatusCreateAction;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;
use Exception;

use function App\Helpers\Mylog;

class OrderUnitUpdateDraftAction
{
    public static function make(OrderUnitVO $vo, OrderUnit $order) : OrderUnit
    {
        return self::run($vo, $order);
    }

    /**
     * @param OrderUnitVO $vo
     * @param OrderUnit $order
     *
     * @return OrderUnit
     */
    private static function run(OrderUnitVO $vo, OrderUnit $order) : OrderUnit
    {

        try {

            //обновляем атрибуты модели через fill
            $order->fill($vo->toArrayNotNull());

            //проверяем данные на 'грязь' - если данные отличаются от старого состояние модели, то обновляем сущность
            if ($order->isDirty()) { $order->save(); $order->refresh(); }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }


        return $order;
    }
}
