<?php

namespace App\Modules\Transport\App\Data\Enums;

use App\Modules\Base\Interface\IEnumStringToObject;
use Exception;

/**
 * Типы кузова
 */
enum TransportBodyType : string implements IEnumStringToObject
{
    case flatbed = 'бортовой';
    case curtainside = 'тентованный';
    case box = 'фургон';
    case refrigerated = 'рефрижератор';
    case tanker = 'цистерна';
    case dump = 'самосвал';
    case car_carrier = 'автовоз';
    case logging = 'лесовоз';
    case crane = 'кран манипулятор';
    case concrete_mixer = 'бетономешалка';
    case tow = 'эвакуатор';
    case insulated = 'изотермический';
    case container = 'контейнеровоз';
    case garbage = 'мусоровоз';
    case livestock = 'животновоз';
    case lowboy = 'низкорамник';
    case scrap_metal = 'ломовоз';
    case covered_flatbed = 'крытый бортовой';
    case bulk_powder_tanker = 'автоцистерна для сыпучих материалов';
    case side_curtain = 'шторный полуприцеп';

    /**
    * Получить значение case в string и прислать объект
    * @param string $value
    *
    * @return self
    */
    public static function stringByCaseToObject(?string $value) : self
    {
        return match ($value) {
            "flatbed" => TransportBodyType::flatbed,
            "curtainside" => TransportBodyType::curtainside,
            "box" => TransportBodyType::box,
            "refrigerated" => TransportBodyType::refrigerated,
            "tanker" => TransportBodyType::tanker,
            "dump" => TransportBodyType::dump,
            "car_carrier" => TransportBodyType::car_carrier,
            "logging" => TransportBodyType::logging,
            "crane" => TransportBodyType::crane,
            "concrete_mixer" => TransportBodyType::concrete_mixer,
            "tow" => TransportBodyType::tow,
            "insulated" => TransportBodyType::insulated,
            "container" => TransportBodyType::container,
            "garbage" => TransportBodyType::garbage,
            "livestock" => TransportBodyType::livestock,
            "lowboy" => TransportBodyType::lowboy,
            "scrap_metal" => TransportBodyType::scrap_metal,
            "covered_flatbed" => TransportBodyType::covered_flatbed,
            "bulk_powder_tanker" => TransportBodyType::bulk_powder_tanker,
            "side_curtain" => TransportBodyType::side_curtain,
            default => throw new Exception('Ошибка преобразование Enum TransportLoadingType', 500),
        };
    }

    public static function stringValueCaseToStringEng(string $value) : string
    {
        return match ($value)
        {
            "бортовой" => "flatbed",
            "тентованный" => "curtainside",
            "фургон" => "box",
            "рефрижератор" => "refrigerated",
            "цистерна" => "tanker",
            "самосвал" => "dump",
            "автовоз" => "car_carrier",
            "лесовоз" => "logging",
            "кран манипулятор" => "crane",
            "бетономешалка" => "concrete_mixer",
            "эвакуатор" => "tow",
            "изотермический" => "insulated",
            "контейнеровоз" => "container",
            "мусоровоз" => "garbage",
            "животновоз" => "livestock",
            "низкорамник" => "lowboy",
            "ломовоз" => "scrap_metal",
            "крытый бортовой" => "covered_flatbed",
            "автоцистерна для сыпучих материалов" => "bulk_powder_tanker",
            "шторный полуприцеп" => "side_curtain",

            null => null,
            default => throw new Exception('Ошибка преобразование Enum TransportBodyType', 500),
        };
    }
}
