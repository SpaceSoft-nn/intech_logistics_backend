<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

enum TransportationStatusEnum : string
{

    case loading = 'На Погрузке';

    case transit = "В Пути";

    case unloading = 'На Разгрузке';



    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObject(?string $value) : ?self
    {


        return match ($value) {

            "transit" => TransportationStatusEnum::transit,
            "unloading" => TransportationStatusEnum::unloading,
            "loading" => TransportationStatusEnum::loading,
            null => null,
            default => throw new Exception("Ошибка преобразование в класса: " . self::class, 500),

        };
    }

    public function getNameCase() : string
    {
        return match ($this)
        {
            TransportationStatusEnum::transit => "transit",
            TransportationStatusEnum::unloading => "unloading",
            TransportationStatusEnum::loading => "loading",
            null => null,
            default => throw new Exception("Ошибка преобразование в класса: " . self::class, 500),
        };
    }
}
