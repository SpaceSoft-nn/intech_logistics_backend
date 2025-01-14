<?php

namespace App\Modules\Base\Enums;

enum WeekEnums : string
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
            "monday" => WeekEnums::monday,
            "tuesday" => WeekEnums::tuesday,
            "wednesday" => WeekEnums::wednesday,
            "thursday" => WeekEnums::thursday,
            "friday" => WeekEnums::friday,
            "saturday" => WeekEnums::saturday,
            "sunday" => WeekEnums::sunday,
        };
    }

    public function getNameCase() : string
    {
        return match ($this)
        {
            WeekEnums::monday => "monday",
            WeekEnums::tuesday => "tuesday",
            WeekEnums::wednesday => "wednesday",
            WeekEnums::thursday => "thursday",
            WeekEnums::friday => "friday",
            WeekEnums::saturday => "saturday",
            WeekEnums::sunday => "sunday",
        };
    }

}
