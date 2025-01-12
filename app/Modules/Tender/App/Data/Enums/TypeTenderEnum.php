<?php

namespace App\Modules\Tender\App\Data\Enums;

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

    public function getNameCase() : string
    {
        return match ($this)
        {
            TypeTenderEnum::periodic => "periodic",
            TypeTenderEnum::single => "single",
        };
    }


}
