<?php

namespace App\Modules\Transport\Common\Tests\Feature;

use Tests\TestCase;
use App\Modules\User\Domain\Models\User;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transport\App\Data\Enums\TransportBodyType;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use Faker\Factory as Faker;

class TransportTest extends TestCase
{

    use RefreshDatabase;

    protected $faker;

    protected function setUp(): void
    {
        parent::setUp(); // Не забываем вызывать родительский метод
        $this->faker = Faker::create();
    }


    public function test_create_transport()
    {

        /** @var User */
        $userCarrier = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::carrier]
        )->has(PhoneList::factory(), 'phone')->create();

        $org_user = $userCarrier->organizations->first();

        /** @var IndividualPeople */
        $individualPeople = IndividualPeople::factory()
            ->for(DriverPeople::factory(), 'individualable')
            ->make();

        $transport = Transport::factory()->make();

        $type_loading = array_column(TransportLoadingType::cases(), 'name');
        $type_weight = array_column(TransportTypeWeight::cases(), 'name');
        $type_body = array_column(TransportBodyType::cases(), 'name');
        $type_status = array_column(TransportStatusEnum::cases(), 'name');


        $postData = [
            "brand_model" => $transport['brand_model'],
            "year" => $transport['year'],
            "transport_number" => $transport['transport_number'],
            "body_volume" => $transport['body_volume'],
            "body_weight" => $transport['body_weight'],
            "type_loading" => $this->faker->randomElement($type_loading),
            "type_weight" => $this->faker->randomElement($type_weight),
            "type_body" => $this->faker->randomElement($type_body),
            "type_status" => $this->faker->randomElement($type_status),
            "organization_id" => $org_user->id,
            "driver_id" => $individualPeople->individualable->id,
            "description" => $transport['description'],
        ];


        // Отправляем POST-запрос на endpoint
        $response = $this->actingAs($userCarrier)
            ->withHeaders([
                'organization_id' => $org_user->id,
            ])
            ->postJson("/api/transports", $postData);


        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);



        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('transports', [
            'id' => $response->json()['data']['id'],
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',

                'brand_model',

                'year',
                'transport_number',
                'body_volume',
                'body_weight',

                "type_loading",
                "type_weight",
                "type_body",
                "type_status",

                "organization_id",
                "driver_id",
                "description",
            ],
            'message'
        ]);
    }
}
