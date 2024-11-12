<?php

namespace App\Modules\OrderUnit\Common\Database\Seeders;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\InteractorModules\AddressOrder\Domain\Actions\LinkOrderToAddressAction;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\PalletSpace\Domain\Models\PalletSpace;
use Cache;
use DateTime;
use Faker\Generator;
use Illuminate\Database\Seeder;

use function App\Helpers\add_time_random;

class OrderUnitSeeder extends Seeder
{

    public function __construct(
        private Generator $faker,
    ) { }


    public function run(): void
    {
        $this->createOrderUnit();
    }

    private function createOrderUnit()
    {
        /**
        * @var Address[]
        */
        $arrayAddress = Cache::get('Address_seeder');

        $organization = Organization::factory()->create();

        $end_date_order = add_time_random(now(), 4);
        $startData = add_time_random($end_date_order, 2);
        $endData = add_time_random($startData);


        {

            //Заказ 1
            $order = OrderUnit::factory()->create([

                'end_date_order' => $end_date_order,
                "body_volume" => 10,
                "order_total" => 45000,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,


            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[1], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[2], $order, TypeStateAddressEnum::coming, $endData));
                }

            }

        }

        {
            //Заказ 2
            $order = OrderUnit::factory()->create([

                "end_date_order" => $end_date_order,
                "body_volume" => 9,
                "order_total" => 70000,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,

            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[3], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[4], $order, TypeStateAddressEnum::coming, $endData));
                }

            }

        }

        {
            //Заказ 3
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 3,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[5], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[6], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

        {
            //Заказ 4
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 15,
                "order_total" => 120000,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,

            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[7], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[8], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

        {
            //Заказ 5
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 20,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

           //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[9], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[10], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

        {
            //Заказ 6
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 31,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[11], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[12], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

        {
            //Заказ 7
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 12,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

             //делаем связки через промежуточные таблицы
             {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[13], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[14], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

        {
            //Заказ 8
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 4,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

           //делаем связки через промежуточные таблицы
           {
            //с cargo_unit
            $this->linkOrderAndCargo($order, $pallet);

            //с адрессами(ом)
            {
                //Адресс отбытия
                LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[15], $order, TypeStateAddressEnum::sending, $startData));

                //Адресс прибытия
                LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[16], $order, TypeStateAddressEnum::coming, $endData));
            }

        }
        }

        {
            //Заказ 9
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 33,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

             //делаем связки через промежуточные таблицы
             {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[17], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[18], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

        {
            //Заказ 10
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 45,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[19], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[20], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

        {
            //Заказ 11
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 25,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[21], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[22], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

        {
            //Заказ 12
            $order = OrderUnit::factory()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 17,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[23], $order, TypeStateAddressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAddressAction::run(OrderToAddressDTO::make($arrayAddress[24], $order, TypeStateAddressEnum::coming, $endData));
                }

            }
        }

    }

    /**
     * #TODO Вынести в action
     * Делаем линвку при связи многие ко многим
     * @return [type]
     */
    private function linkOrderAndCargo(OrderUnit $order, PalletSpace $pallet){

        $cargo_units_ids = CargoUnit::factory()->count($this->faker->numberBetween(2, 12))->create([
            "pallets_space_id" => $pallet->id,
        ]);

        //мапим и делаем ассоциативный массив
        $syncData = $cargo_units_ids->mapWithKeys(function ($value) {
            return [$value->id => ['factor' => 1]];
        });


        $order->cargo_units()->syncWithoutDetaching($syncData->toArray());
    }

}
