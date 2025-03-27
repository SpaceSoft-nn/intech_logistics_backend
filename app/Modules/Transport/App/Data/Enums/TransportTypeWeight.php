<?php

namespace App\Modules\Transport\App\Data\Enums;

use App\Modules\Base\Interface\IEnumStringToObject;
use Exception;

enum TransportTypeWeight : string implements IEnumStringToObject
{

    case extraSmall = 'до 0.8 тонны';
    case small = 'до 1.5 тонны';
    case medium = 'до 3 тонны';
    case large = 'до 5 тонны';
    case extraLarge = 'до 10 тонны';
    case superSize = 'более 10 тонны';

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
            "до 0.8 тонны" => "extraSmall",
            "до 1.5 тонны" => "small",
            "до 3 тонны" => "medium",
            "до 5 тонны" => "large",
            "до 10 тонны" => "extraLarge",
            "более 10 тонны" => "superSize",
            null => null,
            default => throw new Exception('Ошибка преобразование Enum TransportTypeWeight', 500),
        };
    }

}
