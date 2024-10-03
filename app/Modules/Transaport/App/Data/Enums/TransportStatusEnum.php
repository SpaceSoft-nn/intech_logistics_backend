<?php

namespace App\Modules\Transaport\App\Data\Enums;

enum TransportStatusEnum : string
{
    case free = "Свободен";
    case work = "В Эксплуатации";
    case repair = "На ремонте";
}
