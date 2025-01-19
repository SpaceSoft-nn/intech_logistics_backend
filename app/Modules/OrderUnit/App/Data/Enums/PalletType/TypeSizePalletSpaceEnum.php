<?php

namespace App\Modules\OrderUnit\App\Data\Enums\PalletType;

use Exception;

enum TypeSizePalletSpaceEnum : string
{
    case eur = "Паллет EUR";
    case fin = "Паллет FIN";
    case ecom = "Паллет ECOM";

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
            "ecom" => TypeSizePalletSpaceEnum::ecom,
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
        };
    }

    /**
    * Получить значение case и преборазовываем в объект
    * @param string $value
    *
    * @return self
    */
    public static function stringValueToObject(string $value) : self
    {
        return match ($value) {
            "Паллет EUR" => TypeSizePalletSpaceEnum::eur,
            "Паллет FIN" => TypeSizePalletSpaceEnum::fin,
            "Паллет ECOM" => TypeSizePalletSpaceEnum::ecom,
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
        };
    }
}
