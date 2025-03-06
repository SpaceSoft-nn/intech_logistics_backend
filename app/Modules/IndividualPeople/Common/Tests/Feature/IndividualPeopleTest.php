<?php

namespace App\Modules\IndividualPeople\Common\Tests\Feature;

use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;
use Tests\TestCase;


class IndividualPeopleTest extends TestCase
{

    public function test_create_individual_people()
    {

        /** @var User */
        $userCarrier = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::carrier]
        )->has(PhoneList::factory(), 'phone')->create();


        //что бы не указывать body post вручную, имитируем создание ресурса
        /** @var array */
        $individualPeople = IndividualPeople::factory()->make()->toArray();

        // dd($individualPeople);

        // Отправляем POST-запрос на endpoint
        $response = $this->actingAs($userCarrier)
            ->withHeaders([
                'organization_id' => $userCarrier->organizations->first()->id,
            ])
            ->postJson("/api/individual-peoples", $individualPeople);

        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);


        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('individual_peoples', [
            'id' => $response->json()['data']['id_individual_people'],
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id_individual_people',
                'first_name',
                'last_name',
                'father_name',
                'position',
                'other_contact',
                'personal_area_id',
                'email',
                'phone',
                'comment',
            ],
            'message'
        ]);

    }

    public function test_create_driver_people()
    {
        /** @var User */
        $userCarrier = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::carrier]
        )->has(PhoneList::factory(), 'phone')->create();

        $org_user = $userCarrier->organizations->first();


        $individualPeople = IndividualPeople::factory()->create();

        /** @var array */
        $driverArray = DriverPeople::factory()->make();

        $postData = [
            "personal_area_id" => $individualPeople->personal_area->id,
            "individual_people_id" => $individualPeople->id,
            "organization_id" => $org_user->id,
            "series" => $driverArray['series'],
            "number" => $driverArray['number'],
            "date_get" => '25.05.2020',
        ];

        // Отправляем POST-запрос на endpoint
        $response = $this->actingAs($userCarrier)
            ->withHeaders([
                'organization_id' => $org_user->id,
            ])
            ->postJson("/api/individual-peoples/drivers", $postData);

        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);


        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('driver_peoples', [
            'id' => $response->json()['data']['id_driver_people'],
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id_driver_people',
                'personal_area_id',
                'individual_people_id',
                'organization_id',
                'series',
                'number',
                'date_get',
            ],
            'message'
        ]);
    }

}
