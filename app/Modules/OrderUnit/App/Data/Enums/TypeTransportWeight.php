<?php

namespace App\Modules\OrderUnit\App\Data\Enums;


//Тип транспортного средства
enum TypeTransportWeight : string
{
    case Small = '1.5 - 3 тонны';
    case Medium = '5 - 10 тонн';
    case Large = '10 - 20 тонн';
    case ExtraLarge = '20 - 40 тонн';
    case SuperSize = 'Более 40 тонн';

    // Пример использования
    function getWeightCategoryDescription(TypeTransportWeight $category): string {
        return match($category) {
            TypeTransportWeight::Small => 'Маленькая категория груза:' . TypeTransportWeight::Small->value,
            TypeTransportWeight::Medium => 'Средняя категория груза:' . TypeTransportWeight::Medium->value,
            TypeTransportWeight::Large => 'Большая категория груза:' . TypeTransportWeight::Large->value,
            TypeTransportWeight::ExtraLarge => 'Очень большая категория груза:' . TypeTransportWeight::ExtraLarge->value,
            TypeTransportWeight::SuperSize => 'Сверх крупная категория груза:' . TypeTransportWeight::SuperSize->value,
            default => throw new \LogicException("Не правильный тип в функции getWeightCategoryDescription() -> TypeTransportWeight", 500),
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
