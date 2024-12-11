<?php

namespace App\Modules\Transport\App\Data\Enums;

use Exception;

enum TransportTypeEnum : string
{

    //Тип классификация ГИБДД
    //Тип кузова
    //Тип загрузки (справо/сверху)
    //

    case car = 'Малотанажка';
    case semitruck = 'Фура';
    case truck = 'Грузовик';
    case container = 'Контейнер';

    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObject(?string $value) : self
    {
        return match ($value) {
            "car" => TransportTypeEnum::car,
            "semitruck" => TransportTypeEnum::semitruck,
            "truck" => TransportTypeEnum::truck,
            "container" => TransportTypeEnum::container,
            default => throw new Exception('Ошибка преобразование Enum TransportTypeEnum', 500),
        };
    }
}
