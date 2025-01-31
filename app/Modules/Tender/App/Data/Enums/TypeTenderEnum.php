<?php

namespace App\Modules\Tender\App\Data\Enums;

use Exception;

enum TypeTenderEnum : string
{ //Тип тендера выполнения

    case periodic = "Периодический";

    case single = "Разовый";

    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObject(?string $value) : ?self
    {

        return match ($value) {
            "periodic" => TypeTenderEnum::periodic,
            "single" => TypeTenderEnum::single,
        };
    }

    /** Получаем значение имени кейса в string */
    public static function objectValueToStringCaseName(self $value) : string
    {
        return match ($value) {
            TypeTenderEnum::periodic => 'periodic' ,
            TypeTenderEnum::single => 'single',
            default => throw new Exception('Ошибка приобрезование Enum TypeTenderEnum', 500),
        };
    }

    public function getNameCase() : string
    {
        return match ($this)
        {
            TypeTenderEnum::periodic => "periodic",
            TypeTenderEnum::single => "single",
        };
    }


}
