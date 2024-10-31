<?php

namespace App\Modules\Address\App\Data\Enums;

enum TypeAddressEnum : string
{
    case home = "Домашний";
    case work = "Рабочий";
    case delivery = "Адресс Доставки";
}
