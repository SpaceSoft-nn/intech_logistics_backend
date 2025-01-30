<?php

namespace App\Modules\Tender\App\Data\Enums;

enum StatusTenderEnum : string
{ //Статус Тендера

    case draft = "Черновик"; // Создан в черновике

    case published = "Сбор предложений"; // Опубликован в общем доступен - доступен для исполнителей

    case in_work = "В работе"; // В работе

    case accepted = "Принят"; // Опубликован в общем доступен - доступен для исполнителей
}
