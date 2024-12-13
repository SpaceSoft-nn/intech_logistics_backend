<?php

namespace App\Modules\Transport\App\Data\Enums;

use App\Modules\Base\Interface\IEnumStringToObject;
use Exception;

enum TransportStatusEnum : string implements IEnumStringToObject
{
    case free = "свободен";
    case work = "в работе";
    case repair = "на ремонте";

    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return self
    */
    public static function stringByCaseToObject(?string $value) : self
    {
        return match ($value) {
            "free" => TransportStatusEnum::free,
            "work" => TransportStatusEnum::work,
            "repair" => TransportStatusEnum::repair,
            default => throw new Exception('Ошибка преобразование Enum TransportStatusEnum', 500),
        };
    }
}
