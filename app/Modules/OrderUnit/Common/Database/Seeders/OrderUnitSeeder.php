<?php

namespace App\Modules\OrderUnit\Common\Database\Seeders;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\InteractorModules\AddressOrder\Domain\Actions\LinkOrderToAddressAction;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use Cache;
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
            $order = OrderUnit::factory()->withCargoGood()->withCargoGood()->withStatusSet(StatusOrderUnitEnum::draft)->create([

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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::published)->withCargoGood()->create([

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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::accepted)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 3,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {


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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::in_work)->withCargoGood()->create([
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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::completed_and_wait_payment)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 20,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

           //делаем связки через промежуточные таблицы
            {


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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::cancelled)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 31,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {


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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::private)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 12,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {


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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::published)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 4,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

           //делаем связки через промежуточные таблицы
           {


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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::in_work)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 33,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {


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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::in_work)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 45,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {


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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::in_work)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 25,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {


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
            $order = OrderUnit::factory()->withStatusSet(StatusOrderUnitEnum::in_work)->withCargoGood()->create([
                'end_date_order' => $end_date_order,
                "body_volume" => 17,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "address_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {

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

}
