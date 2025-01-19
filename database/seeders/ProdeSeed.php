<?php

namespace Database\Seeders;

use Arr;
use Illuminate\Database\Seeder;
use App\Modules\User\Domain\Models\User;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\Domain\Services\OrganizationService;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\User\Domain\Models\PersonalArea;

class ProdeSeed extends Seeder
{

    public function run(): void
    {

        {
            $user = [
                "first_name" => 'Иван',
                "last_name" => 'Кукушка',
                "father_name" => 'Васильевич',
                "password" => "password",
            ];

            $user = $this->createUser(
                email: 'customer@gmail.com',
                phone: '79200000000',
                typeCabinet: TypeCabinetEnum::customer,
                userValue: $user,
            );

            //создаём OrderUnit для user
            $this->createOrderUnit($user);
        }

        $user = [
            "first_name" => 'Георгий',
            "last_name" => 'Паншин',
            "father_name" => 'Павлович',
            "password" => "password",
        ];

        $this->createUser(
            email: 'carrier@gmail.com',
            phone: '79200000001',
            typeCabinet: TypeCabinetEnum::carrier,
            userValue: $user,
        );

    }

    /**
     * Создаём user
     * @param string $email
     * @param string $phone
     * @param TypeCabinetEnum|null $typeCabinet
     * @param array|null $userValue
     *
     * @return User
     */
    public function createUser(string $email, string $phone, ?TypeCabinetEnum $typeCabinet = null, ?array $userValue = null) : User
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

                $userValue['email_id'] = $email->id;
                $userValue['phone_id'] = $phone->id;

                //создаём user и активируем его в factory
                //Вызываем вместе со связью многие ко многим при установке личного кабинета
                $user = User::factory()->hasAttached(
                    PersonalArea::factory()
                    ->state(function (array $attributes, User $user) {
                        //вызываем callback т.к нам нужно указать самого user
                        return ['owner_id' => $user->id];
                    }),
                    relationship: 'personal_areas',
                )->create($userValue);

                Arr::get($userValue, "email_id", $email->id);
                Arr::get($userValue, "phone_id", $phone->id);
            }

            $orgArray = Organization::factory()->make()->toArray();
            //меняем user на своего
            Arr::set($orgArray, 'owner_id', $user->id);
            Arr::set($orgArray, 'type', "legal");

            /**
            * @var OrganizationVO
            */
            $orgVO = OrganizationVO::fromArrayToObject($orgArray);


            $organization = app(OrganizationService::class)->createOrganization(
                OrganizationCreateDTO::make(
                    organizationVO: $orgVO,
                    user: $user,
                    type_cabinet: $typeCabinet ?? TypeCabinetEnum::customer)
            );

            return $user;
        }
    }

    public function createOrderUnit(User $user)
    {

        $user_id = $user->id;

        $organization_id = $user->organizations[0];

        //получем rep OrderUnit для установки своего статуса
        $orderRep = app(OrderUnitRepository::class);

        { #OrderUnit + cargoGood

            $orderRep = app(OrderUnitRepository::class);

            $arrayCargoGood = [
                'name_value' => '№3254',
                'product_type' => 'Вода',
                'description' => 'Бутилированная вода',
                'body_volume' => '8.5',
            ];

            $order = OrderUnit::factory()->withCargoGood($arrayCargoGood)->create([
                "end_date_order" => now()->addDays(5),
                "order_total" => "180000",
                "description" => 'Нужно доставить заказ по данными адресам',
                "body_volume" => '8.5',
                "user_id" => $user_id,
                "organization_id" => $organization_id,
            ]);

            $orderRep->setStatus(StatusOrderUnitEnum::published, $order->id);

        }

        { #OrderUnit + cargoGood + mgx
            $arrayCargoGood = [
                'name_value' => '№3254',
                'product_type' => 'Металлокорд',
                'description' => 'Металлокорд - проволки и троссы',
                'body_volume' => '18.75',
            ];

            $mgx = [
                "length" => '7.5',
                "width" => '2.5',
                "height" => '1',
                "weight" => '700',
            ];

            $order = OrderUnit::factory()->withCargoGood($arrayCargoGood, $mgx)->create([
                "end_date_order" => now()->addDays(5),
                "order_total" => "275000",
                "description" => 'Нужно доставить заказ по заданным Адрессам.',
                "body_volume" => '18.75',
                "user_id" => $user_id,
                "organization_id" => $organization_id,
            ]);

            $orderRep->setStatus(StatusOrderUnitEnum::published, $order->id);
        }


    }
}
