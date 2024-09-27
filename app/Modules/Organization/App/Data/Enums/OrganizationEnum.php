<?php

namespace App\Modules\Organization\App\Data\Enums;

enum OrganizationEnum : string
{
    case ooo = "ООО"; //Проблема может бытьс case англ => ру буквы
    case ie = "Индивидуальный Предприниматель"; //Проблема может бытьс case англ => ру буквы
}
