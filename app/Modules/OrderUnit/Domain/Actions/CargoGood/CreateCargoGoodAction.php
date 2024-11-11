<?php

namespace App\Modules\OrderUnit\Domain\Actions\CargoGood;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use Exception;

use function App\Helpers\Mylog;

class CreateCargoGoodAction
{

    /**
     * @param CargoGoodVO $vo
     *
     * @return CargoGood|null
     */
    public static function make(CargoGoodVO $vo) : CargoGood
    {
        return (new self())->run($vo);
    }

    /**
    *
    * @return ?CargoGood
    */
    private function run(CargoGoodVO $vo) : CargoGood
    {

        try {

            $сargoGood = CargoGood::createOrFail($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            Mylog('Ошибка в Action CreateCargoGoodAction, при создании модели');
            throw new Exception('Ошибка в AgreementOrderAcceptCreateAction', 500);

        }

        return $сargoGood;
    }
}
