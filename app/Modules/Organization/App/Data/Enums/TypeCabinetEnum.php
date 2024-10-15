<?php

namespace App\Modules\Organization\App\Data\Enums;

use InvalidArgumentException;

enum TypeCabinetEnum : string
{
    case customer = "Заказчик"; //Проблема может бытьс case англ => ру буквы
    case store_space = "Склад"; //Проблема может бытьс case англ => ру буквы
    case сarrier = "Перевозчик"; //Проблема может бытьс case англ => ру буквы

    public static function returnObjectByString(?string $value) : ?self
    {
        return match ($value) {

            'Заказчик' => self::customer,

            'Склад' => self::store_space,

            'Перевозчик' => self::сarrier,

            null => null,

            default => throw new InvalidArgumentException (
                "Не правильный аргумент в функции: [{$value}] не поддерживается" , 500
            ),

        };
    }
}
