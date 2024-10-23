<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderUnitFactory extends Factory
{
    protected $model = OrderUnit::class;

    public function definition(): array
    {
        /**
        * @var Organization
        */
        $organization = Organization::factory()->create();


        #TODP Реализовать создание mgx
        /**
         * @var Mgx
        */
        $mgx = Mgx::factory()->create();

        {

            #TODO Удалить если не будет нужно
            // $deliveryStart = $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'); // Генерируем дату начала в пределах последнего месяца
            // $daysToAdd = rand(2, 7); // Случайное количество дней от 2 до 5

            /**
            * @var OrderUnitVO
            */
            $orderUnitVO = OrderUnitVO::make(
                end_date_order: now(),
                type_load_truck: $this->faker->randomElement(['ltl', 'ftl', 'custom']),
                body_volume: $this->faker->randomFloat(2, 1, 80),
                order_total: $this->faker->numberBetween(50000, 275000),
                description: $this->faker->text(),
                product_type: $this->faker->word(),
                // order_status: StatusOrderUnitEnum::wait,
                user_id: $organization->owner_id,
                organization_id: $organization->id,
            );

        }


        return $orderUnitVO->toArrayNotNull();
    }

}
