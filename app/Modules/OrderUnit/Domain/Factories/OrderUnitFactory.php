<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class OrderUnitFactory extends Factory
{
    protected $model = OrderUnit::class;

    public function definition(): array
    {
        /**
        * @var Organization
        */
        $organization = Organization::factory()->create();

        /**
        * @var \App\Models\Adress[] $adress
        */
        $adress = Adress::factory()->count(2)->create();

        /**
         * @var Mgx
        */
        $mgx = Mgx::factory()->create();

        {

            $deliveryStart = $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'); // Генерируем дату начала в пределах последнего месяца
            $daysToAdd = rand(2, 5); // Случайное количество дней от 2 до 5
            /**
            * @var OrderUnitVO
            */
            $orderUnitVO = OrderUnitVO::make(
                delivery_start: (string) $deliveryStart,
                delivery_end: (new DateTime($deliveryStart))->modify("+{$daysToAdd} days")->format('Y-m-d H:i:s'), // Добавляем случайное количество дней
                adress_start_id: $adress[0]->id,
                adress_end_id: $adress[1]->id,
                body_volume: $this->faker->randomFloat(2, 1, 80),
                order_total: $this->faker->numberBetween(50000, 275000),
                description: $this->faker->text(),
                mgx_id: $mgx->id,
                product_type: $this->faker->word(),
                order_status: StatusOrderUnitEnum::wait,
                user_id: $organization->owner_id,
                organization_id: $organization->id,
            );
        }


        return $orderUnitVO->toArrayNotNull();
    }

}
