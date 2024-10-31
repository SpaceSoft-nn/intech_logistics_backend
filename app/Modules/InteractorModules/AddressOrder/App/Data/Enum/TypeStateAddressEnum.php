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

}
