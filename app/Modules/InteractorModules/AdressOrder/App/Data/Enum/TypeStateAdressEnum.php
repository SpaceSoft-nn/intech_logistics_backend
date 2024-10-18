<?php

namespace App\Modules\InteractorModules\AdressOrder\App\Data\Enum;

use Exception;

enum TypeStateAdressEnum : string
{

    case sending = "Отправка";
    case coming = "Прибытие";

    public static function returnObjectByString(string $data)
    {
        return match ($data) {
            "Отправка" => self::sending,
            "Прибытие" =>  self::coming,
            "default" =>  throw new Exception('Ошибка преобразование string -> TypeStateAdressEnum', 500),
        };
    }

}
