<?php

namespace App\Modules\OrderUnit\App\Data\Enums\PalletType;

use Exception;

enum TypeSizePalletSpaceEnum : string
{
    case eur = "Паллет EUR";
    case fin = "Паллет FIN";
    case eco = "Паллет ECO";

    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return self
    */
    public static function stringByCaseToObject(string $value) : self
    {
        return match ($value) {
            "eur" => TypeSizePalletSpaceEnum::eur,
            "fin" => TypeSizePalletSpaceEnum::fin,
            "eco" => TypeSizePalletSpaceEnum::eco,
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
        };
    }
}
