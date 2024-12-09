<?php

namespace App\Modules\Organization\App\Data\Enums;

use Exception;
use InvalidArgumentException;

enum OrganizationEnum : string
{
    case legal = "ООО";
    case individual = "ИП";


    public static function returnObjectByString(?string $value) : ?self
    {
        return match ($value) {

            'ООО' => self::legal,

            'Индивидуальный Предприниматель' => self::individual,

            null => null,

            default => throw new InvalidArgumentException (
                "Не правильный аргумент в функции: [{$value}] не поддерживается" , 500
            ),

        };
    }

    /**
     * Получить значение case в string и прислать объект
     * @param string $value
     *
     * @return self
    */
    public static function stringByCaseToObject(string $value) : self
    {
        return match ($value) {
            "legal" => OrganizationEnum::legal,
            "individual" => OrganizationEnum::individual,
            default => throw new Exception('Ошибка приобрезование Enum OrganizationEnum', 500),
        };
    }
}
