<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

//Тип транспортного средства
enum TypeTransportWeight : string
{

    case extraSmall = 'до 0.8 тонн';
    case small = 'до 1.5 тонн';
    case medium = 'до 3 тонн';
    case large = 'до 5 тонн';
    case extraLarge = 'до 10 тонн';
    case superSize = 'более 10 тонн';

    // Пример использования
    function getWeightCategoryDescription(TypeTransportWeight $category): string {
        return match($category) {
            TypeTransportWeight::extraSmall => 'Сверх Маленькая категория груза:' . TypeTransportWeight::extraSmall->value,
            TypeTransportWeight::small => 'Маленькая категория груза:' . TypeTransportWeight::small->value,
            TypeTransportWeight::medium => 'Средняя категория груза:' . TypeTransportWeight::medium->value,
            TypeTransportWeight::large => 'Большая категория груза:' . TypeTransportWeight::large->value,
            TypeTransportWeight::extraLarge => 'Очень большая категория груза:' . TypeTransportWeight::extraLarge->value,
            TypeTransportWeight::superSize => 'Сверх крупная категория груза:' . TypeTransportWeight::superSize->value,
            default => throw new \LogicException("Не правильный тип в функции getWeightCategoryDescription() -> TypeTransportWeight", 500),
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
            "extraSmall" => TypeTransportWeight::extraSmall,
            "small" => TypeTransportWeight::small,
            "medium" => TypeTransportWeight::medium,
            "large" => TypeTransportWeight::large,
            "extraLarge" => TypeTransportWeight::extraLarge,
            "superSize" => TypeTransportWeight::superSize,
            default => self::stringValueCaseToObject($value),
        };
    }

    /** Получаем значение имени кейса в string */
    public static function objectValueToStringCaseName(self $value) : string
    {
        return match ($value) {
            TypeTransportWeight::extraSmall => 'extraSmall' ,
            TypeTransportWeight::small => 'small' ,
            TypeTransportWeight::medium => 'medium',
            TypeTransportWeight::large => 'large',
            TypeTransportWeight::extraLarge => 'extraLarge',
            TypeTransportWeight::superSize => 'superSize',
            default => throw new Exception('Ошибка преобрезование Enum TypeTransportWeight', 500),
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
            'до 0.8 тонн'  => TypeTransportWeight::extraSmall,
            'до 1.5 тонн'  => TypeTransportWeight::small,
            'до 3 тонн'  => TypeTransportWeight::medium,
            'до 5 тонн'  => TypeTransportWeight::large,
            'до 10 тонн'  => TypeTransportWeight::extraLarge,
            'более 10 тонн'  => TypeTransportWeight::superSize,
            default => throw new Exception('Ошибка преобрезование Enum TypeTransportWeight', 500),
        };
    }

}


// ### Самые распространенные грузоподъемности в России:
#TODO Чуть поменяли максимальную загруженность
// - 1,5 - 3 тонны:
//   - Часто используются для небольших коммерческих перевозок и доставки товаров в городских условиях.
//   - Примеры: малотоннажные грузовики типа "Газель".

// - 5 - 10 тонн:
//   - Подходят для средней коммерческой деятельности и междугородних перевозок.
//   - Примеры: среднетоннажные грузовики.

// - 10 - 20 тонн:
//   - Популярны в секторе более крупных грузоперевозок, включая строительные материалы и промышленную продукцию.
//   - Примеры: тяжёлые грузовики, такие как "КамАЗ", "МАЗ".

// - 20 - 40 тонн:
//   - Используются для транспортировки особо крупногабаритных грузов на дальние расстояния.
//   - Примеры: автопоезда, фуры с полуприцепами.

// - Более 40 тонн:
//   - Часто применяются для специализированных грузов, таких как тяжелая техника или строительные конструкции.
//   - Примеры: тяжеловесные тралы.

// Эти транспортные средства выбираются в зависимости от специфики груза и условий транспортировки, таких как расстояние и состояние дорог.
