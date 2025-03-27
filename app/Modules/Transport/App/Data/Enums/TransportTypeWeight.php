<?php

namespace App\Modules\Transport\App\Data\Enums;

use App\Modules\Base\Interface\IEnumStringToObject;
use Exception;

enum TransportTypeWeight : string implements IEnumStringToObject
{

    case extraSmall = 'до 0.8 тонн';
    case small = 'до 1.5 тонн';
    case medium = 'до 3 тонн';
    case large = 'до 5 тонн';
    case extraLarge = 'до 10 тонн';
    case superSize = 'более 10 тонн';

    /**
    * Принять в параметр ключ как тип string, и вернуть эквивалетный объект
    * @param string $value
    *
    * @return self
    */
    public static function stringByCaseToObject(?string $value) : self
    {
        return match ($value) {
            "extraSmall" => TransportTypeWeight::extraSmall,
            "small" => TransportTypeWeight::small,
            "medium" => TransportTypeWeight::medium,
            "large" => TransportTypeWeight::large,
            "extraLarge" => TransportTypeWeight::extraLarge,
            "superSize" => TransportTypeWeight::superSize,
            default => throw new Exception('Ошибка преобразование Enum TransportTypeWeight', 500),
        };
    }

    /**
    * Принять в параметр ключ как тип string, и вернуть эквивалетный объект
    * @param string $value
    *
    * @return self
    */
    public static function ObjectByCaseToStringKey(?string $value) : self
    {
        return match ($value) {
            "extraSmall" => TransportTypeWeight::extraSmall,
            "small" => TransportTypeWeight::small,
            "medium" => TransportTypeWeight::medium,
            "large" => TransportTypeWeight::large,
            "extraLarge" => TransportTypeWeight::extraLarge,
            "superSize" => TransportTypeWeight::superSize,
            default => throw new Exception('Ошибка преобразование Enum TransportTypeWeight', 500),
        };
    }

    public static function stringValueCaseToStringEng(string $value) : string
    {
        return match ($value)
        {
            "до 0.8 тонн" => "extraSmall",
            "до 1.5 тонн" => "small",
            "до 3 тонн" => "medium",
            "до 5 тонн" => "large",
            "до 10 тонн" => "extraLarge",
            "более 10 тонн" => "superSize",
            null => null,
            default => throw new Exception('Ошибка преобразование Enum TransportTypeWeight', 500),
        };
    }

}
