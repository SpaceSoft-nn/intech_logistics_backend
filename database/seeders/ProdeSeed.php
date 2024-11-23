<?php

namespace Database\Seeders;

use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\Domain\Services\OrganizationService;
use App\Modules\User\Domain\Models\User;
use Arr;
use Illuminate\Database\Seeder;

class ProdeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUser('test2@gmail.com', '79200000001');
    }

    public function createUser(string $email, string $phone)
    {
        {
            { // создаём данные email и phone
                $email = EmailList::create([
                    // 'value' => 'test@gmail.com',
                    'value' => $email,
                    'status' => true,
                ]);

                $phone = PhoneList::create([
                    // 'value' => '79200000000',
                    'value' => $phone,
                    'status' => true,
                ]);
            }

            //создаём user и активируем его в factory
            $user = User::factory()->create([
                "first_name" => 'Иван',
                "last_name" => 'Кукушка',
                "father_name" => 'Васильевич',
                "password" => "Pass123!",
                "email_id" =>  $email->id,
                "phone_id" =>  $phone->id,
            ]);

            $orgArray = Organization::factory()->make()->toArray();
            //меняем user на своего
            Arr::set($orgArray, 'owner_id', $user->id);
            Arr::set($orgArray, 'type', "legal");

            /**
            * @var OrganizationVO
            */
            $orgVO = OrganizationVO::fromArrayToObject($orgArray);


            $organization = app(OrganizationService::class)->createOrganization(
                OrganizationCreateDTO::make($orgVO, $user, TypeCabinetEnum::customer)
            );


            $this->createOrderUnit($user->id, $organization->id);
        }
    }

    public function createOrderUnit(string $user_id, string $organization_id)
    {

        { // создаёмм
            $orderUnitVoArray = OrderUnit::factory()->make([
                "end_date_order" => now()->addDays(5),
                "description" => 'Нужно доставить заказ по данным Адрессам',
                "order_total" => '180500',
                "body_volume" => '15.5',
                "user_id" => $user_id,
                "organization_id" => $organization_id,
                "type_load_truck" => TypeLoadingTruckMethod::ftl,
            ])->toArray();

            Arr::set($orderUnitVoArray, 'type_load_truck', 'ftl');
            Arr::set($orderUnitVoArray, 'type_transport_weight', 'medium');
        }


        // /**
        // * @var OrderUnitVO
        // */
        // $orderUnitVO = OrderUnitVO::fromArrayToObject($orderUnitVoArray);

        // /**
        // * @var ?CargoGoodVO[]
        // */
        // $cargoGoodVO = $request->createCargoGoodVO();

        // /**
        // * @var OrderUnitAddressDTO
        // */
        // $orderUnitAddressDTO = $request->createOrderUnitAddressDTO();


        /**
        * @var OrderUnit
        */
        // $order = app(OrderUnitService::class)->createOrderUnit(
        //     OrderUnitCreateDTO::make(
        //         orderUnitVO: $orderUnitVO,
        //         orderUnitAddressDTO: $orderUnitAddressDTO,
        //         cargoGoodVO : $cargoGoodVO,
        //     )
        // );


        // dd($orderUnit->addresses[0]->toArray());

    }
}
