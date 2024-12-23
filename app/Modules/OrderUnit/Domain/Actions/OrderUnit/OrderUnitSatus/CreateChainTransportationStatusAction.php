<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\Status\ChainTransportationStatusVO;
use App\Modules\OrderUnit\Domain\Models\Status\ChainTransportationStatus;
use Exception;

use function App\Helpers\Mylog;

class CreateChainTransportationStatusAction
{

    /**
     * @param ChainTransportationStatusVO $vo
     *
     * @return ChainTransportationStatus
     */
    public static function make(ChainTransportationStatusVO $vo) : ChainTransportationStatus
    {
        return self::run($vo);
    }


    private static function run(ChainTransportationStatusVO $vo) : ChainTransportationStatus
    {

        $chainTransportationStatus = ChainTransportationStatus::create($vo->toArray());

        try {



        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $chainTransportationStatus;
    }
}
