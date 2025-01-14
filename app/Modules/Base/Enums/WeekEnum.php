<?php

namespace App\Modules\Base\Enums;


enum WeekEnum : string
{
    case monday = 'Понедельник';
    case tuesday = 'Вторник';
    case wednesday = 'Среда';
    case thursday = 'Четверг';
    case friday = 'Пятница';
    case saturday = 'Субботу';
    case sunday = 'Воскресенье';

     /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObject(?string $value) : ?self
    {

        return match ($value) {
            "monday" => WeekEnum::monday,
            "tuesday" => WeekEnum::tuesday,
            "wednesday" => WeekEnum::wednesday,
            "thursday" => WeekEnum::thursday,
            "friday" => WeekEnum::friday,
            "saturday" => WeekEnum::saturday,
            "sunday" => WeekEnum::sunday,
            default => throw new \TypeError("Не правильный тип в функции getNameCase() -> в классе WeekEnum", 500) ,
        };
    }

    public function getNameCase() : string
    {
        return match ($this)
        {
            WeekEnum::monday => "monday",
            WeekEnum::tuesday => "tuesday",
            WeekEnum::wednesday => "wednesday",
            WeekEnum::thursday => "thursday",
            WeekEnum::friday => "friday",
            WeekEnum::saturday => "saturday",
            WeekEnum::sunday => "sunday",
            default => throw new \TypeError("Не правильный тип в функции getNameCase() -> в классе WeekEnum", 500) ,
        };
    }

}
