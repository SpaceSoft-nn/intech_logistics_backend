<?php

namespace App\Modules\OrderUnit\Common\Database\Seeders;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\InteractorModules\AdressOrder\App\Data\DTO\OrderToAdressDTO;
use App\Modules\InteractorModules\AdressOrder\App\Data\Enum\TypeStateAdressEnum;
use App\Modules\InteractorModules\AdressOrder\Domain\Actions\LinkOrderToAdressAction;
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
        * @var Adress[]
        */
        $arrayAdress = Cache::get('adress_seeder');

        $organization = Organization::factory()->create();

        $end_date_order = add_time_random(now(), 4);
        $startData = add_time_random($end_date_order, 2);
        $endData = add_time_random($startData);


        /**
        * @var PalletSpace
        */
        $pallet = PalletSpace::factory()->create();

        {

            //Заказ 1
            $order = OrderUnit::factory()->create([

                'end_date_order' => $end_date_order,
                "body_volume" => 10,
                "order_total" => 45000,
                "description" => $this->faker->text(),
                "user_id" => $organization->owner_id,
                "organization_id" => $organization->id,
                "adress_is_array" => false,


            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[1], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[2], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,

            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[3], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[4], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[5], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[6], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,

            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[7], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[8], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

           //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[9], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[10], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[11], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[12], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

             //делаем связки через промежуточные таблицы
             {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[13], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[14], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

           //делаем связки через промежуточные таблицы
           {
            //с cargo_unit
            $this->linkOrderAndCargo($order, $pallet);

            //с адрессами(ом)
            {
                //Адресс отбытия
                LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[15], $order, TypeStateAdressEnum::sending, $startData));

                //Адресс прибытия
                LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[16], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

             //делаем связки через промежуточные таблицы
             {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[17], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[18], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[19], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[20], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[21], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[22], $order, TypeStateAdressEnum::coming, $endData));
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
                "adress_is_array" => false,
            ]);

            //делаем связки через промежуточные таблицы
            {
                //с cargo_unit
                $this->linkOrderAndCargo($order, $pallet);

                //с адрессами(ом)
                {
                    //Адресс отбытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[23], $order, TypeStateAdressEnum::sending, $startData));

                    //Адресс прибытия
                    LinkOrderToAdressAction::run(OrderToAdressDTO::make($arrayAdress[24], $order, TypeStateAdressEnum::coming, $endData));
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
