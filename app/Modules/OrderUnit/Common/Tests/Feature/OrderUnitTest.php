<?php

namespace App\Modules\OrderUnit\Common\Tests\Feature;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\InteractorModules\AddressOrder\Domain\Actions\LinkOrderToAddressAction;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnitStatus;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transport\Domain\Models\Transport;
use App\Modules\User\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

use function App\Helpers\add_time_random;

class OrderUnitTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Проверяем работу линковки через промежуточную таблицу Address + OrderUnit
     * @return void
     */
    public function test_link_Address_order()
    {
        $orderUnit = OrderUnit::factory()->create();
        $address = Address::factory()->count(2)->create();

        LinkOrderToAddressAction::run(OrderToAddressDTO::make($address[0], $orderUnit, TypeStateAddressEnum::sending, add_time_random(now(), 0) ));
        LinkOrderToAddressAction::run(OrderToAddressDTO::make($address[1], $orderUnit, TypeStateAddressEnum::coming, add_time_random(now(), 7) ));


        // Проверяем, что коллекция не null
        $this->assertNotNull($orderUnit->addresses->toArray(), 'Коллекция OrderUnit не должна быть null.');

        // Проверяем, что это экземпляр Illuminate\Support\Collection
        $this->assertInstanceOf(Collection::class, $orderUnit->addresses, 'OrderUnit должна быть коллекцией.');

        // Проверяем, что в коллекции ровно 2 элемента
        $this->assertCount(2, $orderUnit->refresh()->addresses->toArray(), 'Коллекция OrderUnit должна содержать ровно 2 элемента.');
    }

    /**
     * Проверка работоспособности endpoint - создание OrderUnit
     * @return void
     */
    public function test_create_order_endpoint() : void
    {
        /** @var Address[] */
        $address = Address::factory()->count(2)->create();

        /** @var User */
        $user = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::customer]
        )->create();


        // Данные для POST-запроса
        $postData = [
            "start_address_id" => $address[0]->id,
            "end_address_id" => $address[1]->id,
            "start_date_delivery" => "01.04.2025",
            "end_date_delivery" => "07.04.2025",
            "goods_array" => [
                [
                    "product_type" => "Молоко",
                    "type_pallet" => "eur",
                    "cargo_units_count" => "4",
                    "body_volume" => "2.3",
                    "name_value" => "Название Груза",
                    "description" => "Какое-то описание груза",
                    "mgx" => [
                        "length" => "4",
                        "width" => "1.2",
                        "height" => "0.75",
                        "weight" => "50"
                    ]
                ]
            ],
            "type_transport_weight" => "small",
            "organization_id" => $user->organizations->first()->id,
            "end_date_order" => "29.12.2023", //Дата окончания Приёма заявок на заказ
            "type_load_truck" => "ftl", //Дата окончания Приёма заявок на заказ
            "body_volume" => "60",
            "order_total" => 100000
        ];

        // Отправляем POST-запрос на endpoint
        $response = $this->actingAs($user)
                        ->withHeaders([
                            'organization_id' => $user->organizations->first()->id
                        ])
                        ->postJson('/api/orders', $postData);

        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);

        // dd($response->json());

        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('order_units', [
            'id' => $response->json()['data']['id'],
        ]);

        // Например, проверяем, что массив содержит конкретные ключи
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body_volume',
                'order_total',
                'cargo_unit_sum',
                'end_date_order',
                'end_date_delivery',
                'type_transport_weight',
                'type_load_truck',
                'end_date_order',
                'add_load_space',
                'change_price',
                'change_time',
                'address_is_array',
                'cargo_goods',
                'goods_is_array',
                'description',
                'order_status',
                'user_id',
                'organization_id',
                'address_array',
                'lot_tender_id',
            ],
            'message'
        ]);



    }

    public function test_response_to_order()
    {

        /** @var User */
        $userCustomer = User::factory()->hasAttached(
                Organization::factory(),
                ['type_cabinet' => TypeCabinetEnum::customer]
            )
            ->has(OrderUnit::factory()->has(OrderUnitStatus::factory(), 'actual_status'), 'order_units')
            ->has(PhoneList::factory(), 'phone')->create();


            /** @var User */
        $userCarrier = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::carrier]
        )->has(PhoneList::factory(), 'phone')->create();


        $id_order = $userCustomer->order_units->first()->id;
        $id_organization_carrier = $userCarrier->organizations->first()->id;

        $transport = Transport::factory()
            ->for($userCarrier->organizations->first(), 'organization')
            ->create();

        $postData = [
            "transport_id" => $transport->id,
            "price" => 100000,
            "date" => '05.05.2022',
            "comment" => 'Коммент',
        ];


        // Отправляем POST-запрос на endpoint
        $response = $this->actingAs($userCarrier)
        ->withHeaders([
            'organization_id' => $id_organization_carrier
        ])
        ->postJson("/api/orders/$id_order/contractors/$id_organization_carrier", $postData);


        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);

        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('organization_order_unit_invoces', [
            'order_unit_id' => $id_order,
            'organization_id' => $id_organization_carrier,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id_organization_order_units_invoce',
                'organization_contract',
                'order',
                'invoice_order',
            ],
            'message'
        ]);

    }

    public function test_response_accept_to_order()
    {

        /** @var User */
        $userCustomer = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::customer]
        )
        ->has(OrderUnit::factory()->has(OrderUnitStatus::factory(), 'actual_status'), 'order_units')
        ->has(PhoneList::factory(), 'phone')->create();


            /** @var User */
        $userCarrier = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::carrier]
        )->has(PhoneList::factory(), 'phone')->create();

        $id_order = $userCustomer->order_units->first()->id;
        $id_organization_carrier = $userCarrier->organizations->first()->id;

        // $transport = Transport::factory()
        //     ->for($userCarrier->organizations->first(), 'organization')
        //     ->create();

        $organization_order_units_invoce = OrganizationOrderUnitInvoice::factory()->create([
            'order_unit_id' => $id_order,
            'organization_id' => $id_organization_carrier,
        ]);

        $postData = [
            'organization_order_units_invoce_id' => $organization_order_units_invoce->id,
        ];


        // Отправляем POST-запрос на endpoint
        $response = $this->actingAs($userCustomer)
            ->withHeaders([
                'organization_id' => $userCustomer->organizations->first()->id,
            ])
            ->postJson("/api/orders/$id_order/agreements/agreement-order", $postData);

        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);


        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('agreement_orders', [
            'order_unit_id' => $id_order,
            'organization_order_units_invoce_id' => $organization_order_units_invoce->id,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id_agreement_order',
                'order_unit_id',
                'organization_contractor_id',
                'organization_order_units_invoce_id',
                'agreement_order_accept_id',
            ],
            'message'
        ]);

    }

    // public function test_agreement_order()
    // {
    //     $model = AgreementOrder::factory()->create();

    //     $this->assertNotNull($model);
    // }

    // public function test_agreement_order_accept()
    // {
    //     $model = AgreementOrderAccept::factory()->create();

    //     $this->assertNotNull($model);
    // }

    // /**
    //  * Тестироование логики работы интерактора когда только главный заказ (2 адресса доставки)
    //  */
    // public function test_create_order_interactor_one_Address()
    // {
    //     $interactor = app(CreateOrderUnitInteractor::class);

    //     /**
    //     * @var Address
    //     */
    //     $addresses = Address::factory()->count(2)->create();

    //     /**
    //     * @var Organization
    //     */
    //     $organization = Organization::factory()->create();

    //     $order = $interactor->execute(
    //         OrderUnitCreateDTO::make(
    //             start_address_id: $addresses[0]->id,
    //             end_address_id: $addresses[1]->id,
    //             start_date_delivery: now(),
    //             end_date_delivery: now(),
    //             organization_id: $organization->id,
    //             end_date_order: now(),
    //             type_load_truck: "ftl",
    //             order_total: 80000,
    //             address_array: null,
    //             product_type: 'Печеньки',
    //             body_volume: 70,
    //             order_status: null,
    //             user_id: $organization->owner_id,
    //             contractors_id: null,
    //             description: 'Test description',
    //         )
    //     )->refresh();

    //     $this->assertNotNull($order);
    //     $this->assertIsArray($order->addresses->toArray());
    //     $this->assertNotEmpty($order->addresses->toArray());
    // }

    //  /**
    //  * Тестироование логики работы интерактора когда главный заказ + (2 адресса) + множество других
    //  */
    // public function test_create_order_interactor_many_Address()
    // {
    //     $interactor = app(CreateOrderUnitInteractor::class);

    //     /**
    //     * @var Address
    //     */
    //     $addresses = Address::factory()->count(4)->create();

    //     /**
    //     * @var Organization
    //     */
    //     $organization = Organization::factory()->create();


    //     /**
    //     * @var OrderUnit
    //     */
    //     $order = $interactor->execute(
    //         OrderUnitCreateDTO::make(
    //             start_address_id: $addresses[0]->id,
    //             end_address_id: $addresses[1]->id,
    //             start_date_delivery: now(),
    //             end_date_delivery: now(),
    //             organization_id: $organization->id,
    //             end_date_order: now(),
    //             type_load_truck: "ltl",
    //             order_total: 80000,
    //             address_array: [
    //                 ["{$addresses[2]->id}" => now(),],
    //                 ["{$addresses[3]->id}" => now(),],
    //             ],
    //             product_type: 'Печеньки',
    //             body_volume: 70,
    //             order_status: null,
    //             user_id: $organization->owner_id,
    //             contractors_id: null,
    //             description: 'Test description',
    //         )
    //     )->refresh();


    //     $this->assertNotNull($order);
    //     $this->assertIsArray($order->addresses->toArray());
    //     $this->assertNotEmpty($order->addresses->toArray());
    // }

}
