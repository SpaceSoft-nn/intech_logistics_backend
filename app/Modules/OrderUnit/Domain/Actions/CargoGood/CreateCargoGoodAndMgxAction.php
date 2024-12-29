<?php

namespace App\Modules\OrderUnit\Domain\Actions\CargoGood;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\MgxVO;
use App\Modules\OrderUnit\Domain\Actions\Mgx\MgxCreateAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use Exception;


use function App\Helpers\Mylog;

class CreateCargoGoodAndMgxAction
{

    /**
     * @param CargoGoodVO $vo
     *
     * @return CargoGood
     */
    public static function make(CargoGoodVO $vo) : CargoGood
    {
        return (new self())->run($vo);
    }

    /**
    * @param CargoGoodVO $vo
    * @return ?CargoGood
    */
    private function run(CargoGoodVO $vo) : CargoGood
    {

        try {

            $сargoGood = CargoGood::create($vo->toArrayNotNull());

            /**
             * @var ?MgxVO
            */
            $mgx = $vo->mgx;

            if(isset($mgx))
            {
                $mgx = MgxCreateAction::make($mgx->withCargoGoodId($сargoGood->id));
            }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $сargoGood;
    }
}
