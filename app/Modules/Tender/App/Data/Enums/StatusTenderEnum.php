<?php

namespace App\Modules\Tender\App\Data\Enums;

use Exception;

enum StatusTenderEnum : string
{ //Статус Тендера

    case draft = "Черновик"; // Создан в черновике

    case published = "Сбор предложений"; // Опубликован в общем доступен - доступен для исполнителей

    case in_work = "В работе"; // В работе

    case accepted = "Принят"; // Опубликован в общем доступен - доступен для исполнителей

    /** Получаем значение имени кейса в string */
    public static function objectValueToStringCaseName(self $value) : string
    {
        return match ($value) {
            StatusTenderEnum::draft => 'draft' ,
            StatusTenderEnum::published => 'published' ,
            StatusTenderEnum::in_work => 'in_work',
            StatusTenderEnum::accepted => 'accepted',
            default => throw new Exception('Ошибка приобрезование Enum TypeTransportWeight', 500),
        };
    }

      /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObject(?string $value) : self
    {
        return match ($value) {
            "draft" => StatusTenderEnum::draft,
            "published" => StatusTenderEnum::published,
            "in_work" => StatusTenderEnum::in_work,
            "accepted" => StatusTenderEnum::accepted,

            default => self::stringValueCaseToObject($value),
        };
    }

        /**
     * Преобразование при получение значение в string в enum экземпляр объекта
     * @param string $value
     *
     * @return self
     */
    public static function stringValueCaseToObject(string $value) : self
    {
        return match ($value) {
            'Черновик'  => StatusTenderEnum::draft,
            'Сбор предложений'  => StatusTenderEnum::published,
            'В работе'  => StatusTenderEnum::in_work,
            'Принят'  => StatusTenderEnum::accepted,
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
        };
    }
}
