<?php

namespace App\Modules\OrderUnit\Common\Database\Seeders;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\PalletSpace\Domain\Models\PalletSpace;
use Cache;
use DateTime;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrderUnitSeeder extends Seeder
{

    public function __construct(
        private Factory $faker,
    ) { parent::__construct(); }



    public function run(): void
    {
        $this->createOrderUnit();
    }

    private function createOrderUnit()
    {
        /**
        * @var Adress[]
        */
        $arrayAdress = Cache::get('adress_seeder');

        $organization = Organization::factory()->create();
        $startData = (new DateTime())->format('Y-m-d');

        /**
        * @var PalletSpace
        */
        $pallet = PalletSpace::factory()->create();

        {
            //Заказ 1
            $order = OrderUnit::factory()->create([
                "delivery_start" => $startData,
                "delivery_end" => $this->setTimeEnd($startData, 5), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[1]->id,
                "adress_end_id" => $arrayAdress[2]->id,
                "body_volume" => 10,
                "order_total" => 45000,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

            $cargo_units = CargoUnit::factory()->count($this->faker->numberBetween(2, 12))->create([
                "pallets_space_id" => $pallet->id,
            ]);

            $order->cargo_units()->syncWithoutDetaching([$cargo_units->pluck('id')->toArray()]);


        }

        {
            //Заказ 2
            OrderUnit::factory()->create([
                "delivery_start" => $startData,
                "delivery_end" => $this->setTimeEnd($startData, 9), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[3]->id,
                "adress_end_id" => $arrayAdress[4]->id,
                "body_volume" => 9,
                "order_total" => 70000,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

        {
            //Заказ 3
            OrderUnit::factory()->create([
                "delivery_start" => $startData,
                "delivery_end" => $this->setTimeEnd($startData, 14), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[5]->id,
                "adress_end_id" => $arrayAdress[6]->id,
                "body_volume" => 3,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

        {
            //Заказ 4
            OrderUnit::factory()->create([
                "delivery_start" => $this->setTimeEnd($startData, 1),
                "delivery_end" => $this->setTimeEnd($startData, 9), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[7]->id,
                "adress_end_id" => $arrayAdress[8]->id,
                "body_volume" => 15,
                "order_total" => 120000,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

        {
            //Заказ 5
            OrderUnit::factory()->create([
                "delivery_start" => $startData,
                "delivery_end" => $this->setTimeEnd($startData, 15), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[9]->id,
                "adress_end_id" => $arrayAdress[10]->id,
                "body_volume" => 20,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

        {
            //Заказ 6
            OrderUnit::factory()->create([
                "delivery_start" => $this->setTimeEnd($startData, 3),
                "delivery_end" => $this->setTimeEnd($startData, 12), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[11]->id,
                "adress_end_id" => $arrayAdress[12]->id,
                "body_volume" => 31,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

        {
            //Заказ 7
            OrderUnit::factory()->create([
                "delivery_start" => $startData,
                "delivery_end" => $this->setTimeEnd($startData, 18), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[13]->id,
                "adress_end_id" => $arrayAdress[14]->id,
                "body_volume" => 12,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

        {
            //Заказ 8
            OrderUnit::factory()->create([
                "delivery_start" => $this->setTimeEnd($startData, 3),
                "delivery_end" => $this->setTimeEnd($startData, 23), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[15]->id,
                "adress_end_id" => $arrayAdress[16]->id,
                "body_volume" => 4,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

        {
            //Заказ 9
            OrderUnit::factory()->create([
                "delivery_start" => $startData,
                "delivery_end" => $this->setTimeEnd($startData, 25), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[17]->id,
                "adress_end_id" => $arrayAdress[18]->id,
                "body_volume" => 33,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

        {
            //Заказ 10
            OrderUnit::factory()->create([
                "delivery_start" => $startData,
                "delivery_end" => $this->setTimeEnd($startData, 4), // Добавляем случайное количество дней
                "adress_start_id" => $arrayAdress[19]->id,
                "adress_end_id" => $arrayAdress[20]->id,
                "body_volume" => 45,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
            ]);

        }

    }

    /**
     * Делаем линвку при связи многие ко многим
     * @return [type]
     */
    private function linkOrderAndCargo($order, ){

        $cargo_units = CargoUnit::factory()->count($this->faker->numberBetween(2, 12))->create([
            "pallets_space_id" => $pallet->id,
        ]);

        $order->cargo_units()->syncWithoutDetaching([$cargo_units->pluck('id')->toArray()]);

    }

    private function setTimeEnd($deliveryStart , int $daysToAdd = null)
    {
        // Вычислите конечную дату, добавив количество дней к начальному дню
        // Вы также можете заменить $daysToAdd на конкретное количество дней или сделать их рандомным значением
        if(is_null($daysToAdd)) { $daysToAdd = random_int(1, 30); }
        $deliveryEnd = (new DateTime($deliveryStart))
                         ->modify("+$daysToAdd days")
                         ->format('Y-m-d H:i:s');

        return $deliveryEnd;
    }

}
