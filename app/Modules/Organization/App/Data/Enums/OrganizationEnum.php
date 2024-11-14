<?php

namespace App\Modules\Organization\App\Data\Enums;

use InvalidArgumentException;

enum OrganizationEnum : string
{
    case legal = "ООО"; //Проблема может бытьс case англ => ру буквы
    case individual = "ИП"; //Проблема может бытьс case англ => ру буквы


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
}
