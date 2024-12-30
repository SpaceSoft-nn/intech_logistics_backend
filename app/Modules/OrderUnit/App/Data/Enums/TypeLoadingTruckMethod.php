<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

enum TypeLoadingTruckMethod : string
{
    case ftl = "Полная Загрузка Грузовика"; //Full Truckload

    case ltl = "Частичная загрузка грузовика"; //Less Than Truckload

    case custom = "Своя Оплата"; //Less Than Truckload

    /**
     * Получить значение case в string и прислать объект
     * @param string $value
     *
     * @return self
     */
    public static function stringByCaseToObject(string $value) : self
    {
        return match ($value) {
            "ftl" => TypeLoadingTruckMethod::ftl,
            "ltl" => TypeLoadingTruckMethod::ltl,
            "custom" => TypeLoadingTruckMethod::custom,
            default => self::stringValueCaseToObject($value),
        };
    }

    public static function stringValueCaseToObject(string $value) : self
    {
        return match ($value) {
            "Полная Загрузка Грузовика" => TypeLoadingTruckMethod::ftl,
            "Частичная загрузка грузовика" => TypeLoadingTruckMethod::ltl,
            "Своя Оплата" => TypeLoadingTruckMethod::custom,
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
        };
    }

}
