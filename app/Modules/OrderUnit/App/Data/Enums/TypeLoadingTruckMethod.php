<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

enum TypeLoadingTruckMethod : string
{
    case ftl = "Полная Загрузка Грузовика"; //Full Truckload

    case ltl = "Частичная загрузка грузовика"; //Less Than Truckload

    case business_lines = "Деловые линии";

    case more_load = "Догрузы";

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
            "business_lines" => TypeLoadingTruckMethod::business_lines,
            "more_load" => TypeLoadingTruckMethod::more_load,
            default => self::stringValueCaseToObject($value),
        };
    }

    public static function stringValueCaseToObject(string $value) : self
    {
        return match ($value) {
            "Полная Загрузка Грузовика" => TypeLoadingTruckMethod::ftl,
            "Частичная загрузка грузовика" => TypeLoadingTruckMethod::ltl,
            "Бизнес линии" => TypeLoadingTruckMethod::business_lines,
            "Догрузы" => TypeLoadingTruckMethod::more_load,
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
        };
    }

    /** Получаем значение имени кейса в string */
    public static function objectValueToStringCaseName(self $value) : string
    {
        return match ($value) {
            TypeLoadingTruckMethod::ftl, => 'ftl',
            TypeLoadingTruckMethod::ltl => 'ltl' ,
            TypeLoadingTruckMethod::business_lines => 'business_lines',
            TypeLoadingTruckMethod::more_load => 'more_load',
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
        };
    }

}
