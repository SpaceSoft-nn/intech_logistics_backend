<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\StatusTransportationEvent\StatusTransportationEventVO;
use App\Modules\OrderUnit\Domain\Models\StatusTransportationEventModel;
use Exception;

use function App\Helpers\Mylog;

class CreateStatusTransportationEventOrderAction
{
    /**
     * @param StatusTransportationEventVO $vo
     *
     * @return StatusTransportationEventModel
     */
    public static function make(StatusTransportationEventVO $vo) : StatusTransportationEventModel
    {
        return self::run($vo);
    }

    /**
     * @param StatusTransportationEventVO $vo
     *
     * @return StatusTransportationEventModel
     */
    private static function run(StatusTransportationEventVO $vo) : StatusTransportationEventModel
    {
        #TODO Отлавливать ошибки

        try {

            $statusTransportationEventModel = StatusTransportationEventModel::create($vo->toArray());

            return $statusTransportationEventModel;

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $statusTransportationEventModel;
    }
}
