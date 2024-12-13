<?php

namespace App\Modules\Transport\App\Data\Enums;

use App\Modules\Base\Interface\IEnumStringToObject;
use Exception;

//Тип загрузки транспортного средства
enum TransportLoadingType : string implements IEnumStringToObject
{
    case top = 'верхняя';
    case side = 'боковая';
    case rear = 'задняя';
    case liquid_bulk = 'наливная';
    case dry_bulk = 'насыпная';


    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return self
    */
    public static function stringByCaseToObject(?string $value) : self
    {
        return match ($value) {
            "top" => TransportLoadingType::top,
            "side" => TransportLoadingType::side,
            "rear" => TransportLoadingType::rear,
            "liquid_bulk" => TransportLoadingType::liquid_bulk,
            "dry_bulk" => TransportLoadingType::dry_bulk,

            default => throw new Exception('Ошибка преобразование Enum TransportLoadingType', 500),
        };
    }
}
