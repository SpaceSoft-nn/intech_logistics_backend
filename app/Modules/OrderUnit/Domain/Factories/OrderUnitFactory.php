<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\InteractorModules\AddressOrder\Domain\Actions\LinkOrderToAddressAction;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnitToCargoGood\OrderUnitToCargoGoodDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus\OrderUnitStatusVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\LinkOrderUnitToCargoGoodAction;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus\OrderUnitStatusCreateAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
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


        {

            #TODO Удалить если не будет нужно
            // $deliveryStart = $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'); // Генерируем дату начала в пределах последнего месяца

            $type_load_truck = $this->faker->randomElement(['ltl', 'ftl', 'custom']);
            $type_transport_weight = $this->faker->randomElement(['small', 'medium', 'large']);

            /**
            * @var OrderUnitVO
            */
            $orderUnitVO = OrderUnitVO::make(
                end_date_order: now(),
                type_load_truck: $type_load_truck,
                body_volume: $this->faker->randomFloat(2, 1, 80),
                order_total: $this->faker->numberBetween(50000, 275000),
                description: $this->faker->text(),

                order_status: null,

                type_transport_weight: $type_transport_weight,

                user_id: $organization->owner_id,
                organization_id: $organization->id,
                contractors_id: null,
                add_load_space: OrderUnitVO::filterEnumTypeLoad($type_load_truck)
            );

            return $orderUnitVO->toArrayNotNull();
        }

    }


    public function configure(): static
    {
        return $this->afterCreating(function (OrderUnit $orderUnit) {


            if($orderUnit->addresses->isEmpty()) {

                //Привязываем Адресса
                $addresses = Address::factory()->count(2)->create();

                LinkOrderToAddressAction::run(
                    OrderToAddressDTO::make(
                        address: $addresses[0],
                        order: $orderUnit,
                        type_status: TypeStateAddressEnum::sending,
                        date: now(),
                    )
                );

                LinkOrderToAddressAction::run(
                    OrderToAddressDTO::make(
                        address: $addresses[1],
                        order: $orderUnit,
                        type_status: TypeStateAddressEnum::coming,
                        date: now(),
                    )
                );


            }



            //Привязываем груз
            /**
            * @var CargoGood
            */
            $cargoGood = CargoGood::factory()->create();

            LinkOrderUnitToCargoGoodAction::run(
                OrderUnitToCargoGoodDTO::make(
                    cargoGood: $cargoGood,
                    orderUnit: $orderUnit,
                )
            );

            //Сделали так для проверки работы endpoint get-schem (algorithm в контроллере)
            if($orderUnit->address_is_array == false){

                //Создание статуса
                 OrderUnitStatusCreateAction::make(
                    OrderUnitStatusVO::make(
                        order_unit_id: $orderUnit->id,
                        status : 'published',
                    )
                );

            } else {

                //Создание статуса
                OrderUnitStatusCreateAction::make(
                    OrderUnitStatusVO::make(
                        order_unit_id: $orderUnit->id,
                    )
                );

            }






        });
    }

}
