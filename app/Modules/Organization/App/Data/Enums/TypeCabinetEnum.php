<?php

namespace App\Modules\Organization\App\Data\Enums;

use Exception;
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

    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return self
    */
    public static function stringByCaseToObject(string $value) : self
    {

        return match ($value) {
            "customer" => TypeCabinetEnum::customer,
            "store_space" => TypeCabinetEnum::store_space,
            "сarrier" => TypeCabinetEnum::сarrier,
            default => throw new Exception('Ошибка приобрезование Enum TypeCabinetEnum', 500),
        };
    }
}
