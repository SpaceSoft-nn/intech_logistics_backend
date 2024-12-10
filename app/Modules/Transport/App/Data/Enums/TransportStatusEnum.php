<?php

namespace App\Modules\Transport\App\Data\Enums;

use Exception;

enum TransportStatusEnum : string
{
    case free = "Свободен";
    case work = "В Эксплуатации";
    case repair = "На ремонте";

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
