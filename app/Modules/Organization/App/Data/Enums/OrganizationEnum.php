<?php

namespace App\Modules\Organization\App\Data\Enums;

use InvalidArgumentException;

enum OrganizationEnum : string
{
    case ooo = "ООО"; //Проблема может бытьс case англ => ру буквы
    case ie = "Индивидуальный Предприниматель"; //Проблема может бытьс case англ => ру буквы

    public static function returnObjectByString(?string $value) : ?self
    {
        return match ($value) {

            'ООО' => self::ooo,

            'Индивидуальный Предприниматель' => self::ie,

            null => null,

            default => throw new InvalidArgumentException (
                "Не правильный аргумент в функции: [{$value}] не поддерживается" , 500
            ),

        };
    }
}
