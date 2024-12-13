<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

enum StatusOrderUnitEnum : string
{

    case draft = "Черновик"; // Создан в черновике

    case published = "Сбор предложений"; // Опубликован в общем доступен - доступен для исполнителей

    case accepted = "Принят"; // Опубликован в общем доступен - доступен для исполнителей

    case in_work = "В работе"; // В работе

    case completed_and_wait_payment = "Выполнен и ожидает оплаты"; //Снят из общего доступа

    case cancelled = "Отменен/Отозван"; // В работе

    case private = "Закрыт"; //Запревачен (видно не всем)

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
            "accepted" => StatusOrderUnitEnum::accepted,
            "in_work" => StatusOrderUnitEnum::in_work,
            "completed_and_wait_payment" => StatusOrderUnitEnum::completed_and_wait_payment,
            "cancelled" => StatusOrderUnitEnum::cancelled,
            null => null,
            default => throw new Exception('Ошибка преобразование Enum StatusOrderUnitEnum', 500),

        };
    }

    public function getNameCase() : string
    {
        return match ($this)
        {
            StatusOrderUnitEnum::draft => "draft",
            StatusOrderUnitEnum::published=> "published",
            StatusOrderUnitEnum::private => "private",
            StatusOrderUnitEnum::accepted => "accepted",
            StatusOrderUnitEnum::in_work => "in_work",
            StatusOrderUnitEnum::completed_and_wait_payment => "completed_and_wait_payment",
            StatusOrderUnitEnum::cancelled => "cancelled",
            null => null,
            default => throw new Exception('Ошибка преобразование Enum StatusOrderUnitEnum', 500),
        };
    }
}
