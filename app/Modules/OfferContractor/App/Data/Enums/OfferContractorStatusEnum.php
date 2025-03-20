<?php

namespace App\Modules\OfferContractor\App\Data\Enums;

use Exception;

enum OfferContractorStatusEnum : string
{

    case draft = "Черновик"; // Создан в черновике

    case published = "Сбор предложений"; // Опубликован в общем доступен - доступен для исполнителей

    case accepted = "Принят"; // Опубликован в общем доступен - доступен для исполнителей

    case in_work = "В работе"; // В работе


    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObject(?string $value) : ?self
    {

        return match ($value) {

            "draft" => OfferContractorStatusEnum::draft,
            "published" => OfferContractorStatusEnum::published,
            "accepted" => OfferContractorStatusEnum::accepted,
            "in_work" => OfferContractorStatusEnum::in_work,
            null => null,
            default => self::stringValueCaseToObject($value),

        };
    }

    /**
    * Получить значение case в string и прислать массив объектов
    * @param string $value
    *
    * @return ?self
    */
    public static function stringByCaseToObjectArray(array $arrays) : array
    {
        $arrNew[] = null;

        foreach ($arrays as $arr => $value) {

            $arrNew[] = match ($value) {
                "draft" => OfferContractorStatusEnum::draft,
                "published" => OfferContractorStatusEnum::published,
                "accepted" => OfferContractorStatusEnum::accepted,
                "in_work" => OfferContractorStatusEnum::in_work,
                default => null,
                null => null,
            };
        }

        return $arrNew;
    }

    public function getNameCase() : string
    {
        return match ($this)
        {
            OfferContractorStatusEnum::draft => "draft",
            OfferContractorStatusEnum::published => "published",
            OfferContractorStatusEnum::accepted => "accepted",
            OfferContractorStatusEnum::in_work => "in_work",
            null => null,
            default => throw new Exception('Ошибка преобразование Enum OfferContractorStatusEnum', 500),
        };
    }

    public static function stringValueCaseToObject(string $value) : self
    {
        return match ($value)
        {
            "Черновик" => OfferContractorStatusEnum::draft,
            "Сбор предложений" => OfferContractorStatusEnum::published,
            "Принят" => OfferContractorStatusEnum::accepted,
            "В работе" => OfferContractorStatusEnum::in_work,
            null => null,
            default => throw new Exception('Ошибка преобразование Enum OfferContractorStatusEnum', 500),
        };
    }


}
