<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;
use App\Modules\OrderUnit\Common\Helpers\Pallets\PalletSize;
use App\Modules\OrderUnit\Common\Helpers\Pallets\PalletSizeHelper;
use App\Modules\OrderUnit\Domain\Actions\CargoGood\CreateCargoGoodAndMgxAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use Exception;

use function App\Helpers\Mylog;

class CargoGoodService
{

    public function createCargoGood(CargoGoodVO $vo) : CargoGood
    {
        return CreateCargoGoodAndMgxAction::make($vo);
    }

    /**
     * Подсчитывает общий объём груза и Общий Объём паллета, и присылаем true, если объём удовлетворяет, объёму паллета
     * @return bool
     */
    public function isTrueCalculateBodyVolumeGeneral(CargoGood $cargoGood) : bool
    {

        if(is_null($cargoGood->mgx)) {
            Mylog('Ошибка в CargoGoodService в методе isTrueCalculateBodyVolumeGeneral');
            throw new Exception('У Груза нету кастомных указанных Характеристик', 500);
        }

        /**
        * @var TypeSizePalletSpaceEnum
        */
        $type_pallet = $cargoGood->type_pallet;

        /**
        * @var PalletSize
        */
        $sizePallet = PalletSizeHelper::getSize($type_pallet);

        return $sizePallet->SatisfoSizeModel($cargoGood->mgx);
    }
}
