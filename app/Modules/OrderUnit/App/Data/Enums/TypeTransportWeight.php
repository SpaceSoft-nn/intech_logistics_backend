<?php

namespace App\Modules\OrderUnit\App\Data\Enums;

use Exception;

//Тип транспортного средства
enum TypeTransportWeight : string
{

    case extraSmall = 'до 0.8 тонны';
    case small = 'до 1.5 тонны';
    case medium = 'до 3 тонны';
    case large = 'до 5 тонны';
    case extraLarge = 'до 10 тонны';
    case superSize = 'более 10 тонны';

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
            "extraSmall" => TypeTransportWeight::small,
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
            'до 0.8 тонны'  => TypeTransportWeight::extraSmall,
            'до 1.5 тонны'  => TypeTransportWeight::small,
            'до 3 тонны'  => TypeTransportWeight::medium,
            'до 5 тонны'  => TypeTransportWeight::large,
            'до 10 тонны'  => TypeTransportWeight::extraLarge,
            'более 10 тонны'  => TypeTransportWeight::superSize,
            default => throw new Exception('Ошибка приобрезование Enum TypeLoadingTruckMethod', 500),
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
