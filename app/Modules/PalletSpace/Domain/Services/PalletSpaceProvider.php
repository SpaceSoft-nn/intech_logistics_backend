<?php

namespace App\Modules\PalletSpace\Domain\Services;

use App\Modules\PalletSpace\App\Data\Enums\TypeSizePalletSpaceEnum;
use App\Modules\PalletSpace\Common\Helpers\PalletSize;
use App\Modules\PalletSpace\Common\Helpers\PalletSizeHelper;

class PalletSpaceProvider
{
    /**
     * Получаем класс PalletSize - у которого есть
     * @param TypeSizePalletSpaceEnum $palletType
     *
     * @return PalletSize
     */
    public function getSicePallet(TypeSizePalletSpaceEnum $palletType) : PalletSize
    {
        return PalletSizeHelper::getSize($palletType);
    }
}
