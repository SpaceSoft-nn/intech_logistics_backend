<?php

namespace App\Modules\Organization\App\Data\Enums;

use Exception;
use InvalidArgumentException;
use Str;

enum TypeCabinetEnum : string
{

    case customer = "Заказчик"; //Проблема может бытьс case англ => ру буквы
    case store_space = "Склад"; //Проблема может бытьс case англ => ру буквы
    case carrier = "Перевозчик"; //Проблема может бытьс case англ => ру буквы

    public static function returnObjectByString(?string $value) : ?self
    {
        $value = Str::lower($value);

        return match ($value) {

            'заказчик' => self::customer,

            'склад' => self::store_space,

            'перевозчик' => self::carrier,

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
            "carrier" => TypeCabinetEnum::carrier,
            default => throw new Exception('Ошибка приобрезование Enum TypeCabinetEnum', 500),
        };
    }

    public static function isCustomer(TypeCabinetEnum $enum) : bool
    {
        return self::customer === $enum;
    }

    public static function iscarrier(TypeCabinetEnum $enum) : bool
    {
        return self::carrier === $enum;
    }
}
