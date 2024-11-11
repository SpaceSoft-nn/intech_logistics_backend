<?php

namespace App\Modules\OrderUnit\Common\Helpers\Pallets;

use App\Modules\OrderUnit\App\Data\Enums\PalletTypeSize\TypeSizePalletSpaceEnum;

class PalletSizeHelper
{
    public static function getSize(TypeSizePalletSpaceEnum $palletType, ?float $height = null): PalletSize
    {
        return match ($palletType) {
            TypeSizePalletSpaceEnum::eur => new PalletSize(1.2, 0.8, $height), // Размеры в метрах
            TypeSizePalletSpaceEnum::fin => new PalletSize(1.2, 0.8, $height), // Размеры в метрах
            TypeSizePalletSpaceEnum::eco => new PalletSize(1.2, 1.1, $height), // Размеры в метрах
        };
    }
}

