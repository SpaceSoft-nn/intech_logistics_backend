<?php

namespace App\Modules\PalletSpace\Common\Helpers;

use App\Modules\PalletSpace\App\Data\Enums\TypeSizePalletSpaceEnum;

class PalletSizeHelper
{
    public static function getSize(TypeSizePalletSpaceEnum $palletType, ?float $height = null): PalletSize
    {
        return match ($palletType) {
            TypeSizePalletSpaceEnum::eur => new PalletSize(1.2, 0.8, $height), // Размеры в метрах
            TypeSizePalletSpaceEnum::fin => new PalletSize(1.2, 1.0, $height), // Размеры в метрах
            TypeSizePalletSpaceEnum::eco => new PalletSize(1.1, 1.1, $height), // Размеры в метрах
        };
    }
}

