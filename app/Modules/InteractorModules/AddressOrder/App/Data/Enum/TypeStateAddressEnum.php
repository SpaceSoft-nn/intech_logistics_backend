<?php

namespace App\Modules\InteractorModules\AddressOrder\App\Data\Enum;

use Exception;

enum TypeStateAddressEnum : string
{

    case sending = "Отправка";
    case coming = "Прибытие";

    public static function returnObjectByString(string $data)
    {
        return match ($data) {
            "Отправка" => self::sending,
            "Прибытие" =>  self::coming,
            "default" =>  throw new Exception('Ошибка преобразование string -> TypeStateAddressEnum', 500),
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
            "sending" => TypeStateAddressEnum::sending,
            "coming" => TypeStateAddressEnum::coming,
            default => throw new Exception('Ошибка приобрезование Enum TypeStateAddressEnum', 500),
        };
    }

}
