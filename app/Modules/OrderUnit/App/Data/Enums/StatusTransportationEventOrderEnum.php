<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

enum StatusTransportationEventOrderEnum : string
{

    case transit = "В Пути";

    case unloading = 'На Разгрузке';

    case loading = 'На Разгрузке';


    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObject(?string $value) : ?self
    {


        return match ($value) {

            "transit" => StatusTransportationEventOrderEnum::transit,
            "unloading" => StatusTransportationEventOrderEnum::unloading,
            "loading" => StatusTransportationEventOrderEnum::loading,
            null => null,
            default => throw new Exception("Ошибка преобразование в класса: " . self::class, 500),

        };
    }

    public function getNameCase() : string
    {
        return match ($this)
        {
            StatusTransportationEventOrderEnum::transit => "transit",
            StatusTransportationEventOrderEnum::unloading => "unloading",
            StatusTransportationEventOrderEnum::loading => "loading",
            null => null,
            default => throw new Exception("Ошибка преобразование в класса: " . self::class, 500),
        };
    }
}
