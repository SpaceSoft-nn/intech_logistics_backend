<?php

namespace App\Modules\Transport\App\Data\Enums;

enum TransportStatusEnum : string
{
    case free = "Свободен";
    case work = "В Эксплуатации";
    case repair = "На ремонте";
}
