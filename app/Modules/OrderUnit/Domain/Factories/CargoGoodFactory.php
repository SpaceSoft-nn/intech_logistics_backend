<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\CargoUnitToCargoGood\CargoUnitToCargoGoodDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\Domain\Actions\LinkCargoUnitToCargoGoodAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class CargoGoodFactory extends Factory
{
    protected $model = CargoGood::class;

    public function definition(): array
    {

        {
            $this->faker = Faker::create('ru_RU');

            $physicalProductTypes = [
                'Одежда',
                'Обувь',
                'Аксессуары',
                'Косметика',
                'Бижутерия',
                'Часы',
                'Электроприборы',
                'Телевизоры',
                'Смартфоны',
                'Планшеты',
                'Ноутбуки',
                'Кулинарные книги',
                'Спортивная одежда',
                'Спортивная обувь',
                'Игрушки для детей',
                'Настольные игры',
                'Пазлы',
                'Книги по саморазвитию',
                'Романтические книги',
                'Научная литература',
                'Учебники',
                'Настольные компьютеры',
                'Микроволновые печи',
                'Холодильники',
                'Стиральные машины',
                'Посудомоечные машины',
                'Кухонные комбайны',
                'Фены',
                'Утюги',
                'Камеры',
                'Фотоаппараты',
                'Принтеры',
                'Наушники',
                'Колонки',
                'Игровые консоли',
                'Видеоигры',
                'Гаджеты для дома',
                'Оборудование для фитнеса',
                'Боксы для хранения',
                'Декор для дома',
                'Мебель',
                'Кухонные принадлежности',
                'Посуда',
                'Столовые приборы',
                'Постельное белье',
                'Ковры',
                'Текстиль',
                'Освещение',
                'Зеркала',
                'Садовая мебель',
                'Садовые инструменты',
                'Семена растений',
                'Удобрения',
                'Оборудование для ухода за садом',
                'Строительные материалы',
                'Краски',
                'Обои',
                'Мобильные аксессуары',
                'Зарядные устройства',
                'Чехлы для телефонов',
                'Лампы',
                'Батарейки',
                'Оборудование для гурманов',
                'Стейки и маринады',
                'Замороженные продукты',
                'Консервы',
                'Напитки',
                'Сладости',
                'Закуски',
                'Здоровое питание',
                'Спортивное питание',
                'Витамины и добавки',
                'Фрукты',
                'Овощи',
                'Мясо',
                'Рыба',
                'Молочные продукты',
                'Кофе',
                'Чай',
                'Специи',
                'Соусы',
                'Инструменты для рукоделия',
                'Ткани',
                'Вязаные изделия',
                'Кожаные изделия',
                'Ручная работа',
                'Музыкальные инструменты',
                'Сувениры'
            ];

            $productType = $this->faker->randomElement($physicalProductTypes);

            /**
            * @var CargoGoodVO
            */
            $orderUnitVO = CargoGoodVO::make(
                product_type: $productType,
                cargo_units_count: $this->faker->numberBetween(4, 12),
                body_volume: $this->faker->randomFloat(2, 1, 80),
                type_pallet: $this->faker->randomElement(['eur', 'fin', 'eco']),
                mgx: null,
                name_value: $this->faker->words(3, true),
                description: $this->faker->text(100),
            );

            return $orderUnitVO->toArrayNotNull();
        }

    }


    /**
     * @param ?array $mgx
     *
     * @return [type]
     */
    public function withMgx(array $mgx = null)
    {
        return $this->afterCreating(function (CargoGood $cargoGood) use ($mgx) {

            if(!is_null($mgx)) {

                $array = Arr::add($mgx, 'cargo_good_id', $cargoGood->id);

                /**
                * @var Mgx
                */
                $mgx = Mgx::factory()->create($array);

            } else {

                /**
                * @var Mgx
                */
                $mgx = Mgx::factory()->create([
                    'cargo_good_id' => $cargoGood->id,
                ]);
            }


        });
    }

    public function configure(): static
    {
        return $this->afterCreating(function (CargoGood $cargoGood) {

            // TODO Продумать нужно ли
            for ($i = 0; $i < $cargoGood->cargo_units_count; $i++) {

                $cargoUnit = CargoUnit::factory()->create([
                    'pallets_space' => $cargoGood->type_pallet,
                ]);

                LinkCargoUnitToCargoGoodAction::run(
                    CargoUnitToCargoGoodDTO::make(
                        cargoGood: $cargoGood,
                        cargoUnit: $cargoUnit,
                        factor: 95,
                    )
                );

            }


        });
    }


}
