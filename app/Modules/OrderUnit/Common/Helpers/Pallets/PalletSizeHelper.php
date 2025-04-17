<?php

namespace App\Modules\OrderUnit\Common\Helpers\Pallets;

use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;

class PalletSizeHelper
{
    public static function getSize(TypeSizePalletSpaceEnum $palletType, ?float $height = null): PalletSize
    {
        return match ($palletType) {
            TypeSizePalletSpaceEnum::eur => new PalletSize(1.2, 0.8, $height ?? 1.8), // Размеры в метрах
            TypeSizePalletSpaceEnum::fin => new PalletSize(1.2, 0.8, $height ?? 1.8), // Размеры в метрах
            TypeSizePalletSpaceEnum::ecom => new PalletSize(1.2, 0.8, $height ?? 1.5), // Размеры в метрах
        };

        
    }
}

