<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

enum StatusOrderUnitEnum : string
{
    case wait = "В ожидании";
    case progress = "В процессе";
}
