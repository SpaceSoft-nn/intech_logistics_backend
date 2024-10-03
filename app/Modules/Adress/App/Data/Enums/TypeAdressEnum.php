<?php

namespace App\Modules\Adress\App\Data\Enums;

enum TypeAdressEnum : string
{
    case home = "Домашний";
    case work = "Рабочий";
    case delivery = "Адресс Доставки";
}
