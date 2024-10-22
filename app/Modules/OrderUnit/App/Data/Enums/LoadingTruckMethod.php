<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

enum LoadingTruckMethod : string
{
    case ftl = "Полная Загрузка Грузовика"; //Full Truckload

    case ltl = "Частичная загрузка грузовика"; //Less Than Truckload

}
