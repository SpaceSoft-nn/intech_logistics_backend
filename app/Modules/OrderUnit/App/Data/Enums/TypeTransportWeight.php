<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

//Тип транспортного средства
enum TypeTransportWeight : string
{

    case small = '1.5 - 3 тонны';
    case medium = '5 - 10 тонн';
    case large = '10 - 20 тонн';
    case extraLarge = '20 - 40 тонн';
    case superSize = 'Более 40 тонн';

    // Пример использования
    function getWeightCategoryDescription(TypeTransportWeight $category): string {
        return match($category) {
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
            "small" => TypeTransportWeight::small,
            "medium" => TypeTransportWeight::medium,
            "large" => TypeTransportWeight::large,
            "extraLarge" => TypeTransportWeight::extraLarge,
            "superSize" => TypeTransportWeight::superSize,
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
            "1.5 - 3 тонны" => TypeTransportWeight::small,
            "5 - 10 тонн" => TypeTransportWeight::medium,
            "10 - 20 тонн" => TypeTransportWeight::large,
            "20 - 40 тонн" => TypeTransportWeight::extraLarge,
            "Более 40 тонн" => TypeTransportWeight::superSize,
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
        };
    }

}


// ### Самые распространенные грузоподъемности в России:

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
