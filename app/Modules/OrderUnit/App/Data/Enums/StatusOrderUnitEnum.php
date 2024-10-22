<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

enum StatusOrderUnitEnum : string
{

    case draft = "Черновик"; // Создан в черновике

    case published = "Опубликован"; // Опубликован в общем доступен

    case private = "Закрыт"; //Запревачен (видно не всем)

    case close = "Отозван"; //Снят из общего доступа

    case progress = "В процессе"; // В работе

    case delete = "Полностью удален"; // В работе

}
