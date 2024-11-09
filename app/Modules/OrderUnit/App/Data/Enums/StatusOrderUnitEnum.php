<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

enum StatusOrderUnitEnum : string
{

    case draft = "Черновик"; // Создан в черновике

    case published = "Опубликован"; // Опубликован в общем доступен

    case private = "Закрыт"; //Запревачен (видно не всем)

    case close = "Отозван"; //Снят из общего доступа

    case progress = "В процессе"; // В работе

    case delete = "Полностью удален"; // В работе

       /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObject(?string $value) : ?self
    {
        return match ($value) {
            "draft" => StatusOrderUnitEnum::draft,
            "published" => StatusOrderUnitEnum::published,
            "private" => StatusOrderUnitEnum::private,
            "close" => StatusOrderUnitEnum::close,
            "progress" => StatusOrderUnitEnum::progress,
            "delete" => StatusOrderUnitEnum::delete,
            null => null,
            default => throw new Exception('Ошибка преобразование Enum StatusOrderUnitEnum', 500),
        };
    }

}
