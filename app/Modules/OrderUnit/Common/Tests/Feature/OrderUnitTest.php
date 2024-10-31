<?php

namespace App\Modules\OrderUnit\Common\Tests\Feature;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\InteractorModules\AddressOrder\Domain\Actions\LinkOrderToAddressAction;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\Domain\Actions\LinkOrderUnitToCargoUnitAction;
use App\Modules\OrderUnit\Domain\Interactor\Order\CreateOrderUnitInteractor;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

use function App\Helpers\add_time_random;

class OrderUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_unit_factory()
    {
        $orderUnits = OrderUnit::factory()->create();

        $this->assertNotNull($orderUnits);

        $this->assertGreaterThan(0, $orderUnits->addresses()->count());
    }

    public function test_create_mgx_factory()
    {
        $mgx = Mgx::factory()->create();

        $this->assertNotNull($mgx);
    }

    public function test_create_cargo_unit_factory()
    {
        $cargoUnit = CargoUnit::factory()->create();

        $this->assertNotNull($cargoUnit);
    }

    /**
     * Тестирование action линковки через промежуточную таблицу при связи многие ко многим.
     * @return void
     */
    public function test_action_manyToMany_orderUnit_andCargoUnit()
    {
        $orderUnits = OrderUnit::factory()->create();
        $cargoUnit = CargoUnit::factory()->create();
        $status = LinkOrderUnitToCargoUnitAction::run($orderUnits, $cargoUnit);

        $this->assertTrue($status);
    }

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
        $this->assertCount(4, $orderUnit->addresses->toArray(), 'Коллекция OrderUnit должна содержать ровно 2 элемента.');
    }

    /**
     * Проверка работоспособности endpoint - создание OrderUnit
     * @return void
     */
    public function test_create_order_endpoint() : void
    {

        $Address = Address::factory()->count(2)->create();

        $organization = Organization::factory()->create();

        // Данные для POST-запроса
        $postData = [
            "start_Address_id" => $Address[0]->id,
            "end_Address_id" => $Address[1]->id,
            "organization_id" =>  $organization->id,

            "start_date_delivery" => now(),
            "end_date_delivery" => now(),

            "end_date_order" => "25.10.2024",

            "product_type" => "Кукуруза",
            "body_volume" => "60",

            "type_load_truck" => "ltl",
            "order_total" => "10000",

            "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. In, dolorum?"
        ];

        // Отправляем POST-запрос на ваш endpoint
        $response = $this->post('/api/orders', $postData);



        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);

        // Например, проверяем, что массив содержит конкретные ключи
        $response->assertJsonStructure([
            'data' => [
                'id',
                'body_volume',
                'order_total',
                'type_load_truck',
                'end_date_order',
                'add_load_space',
                'change_price',
                'change_time',
                'description',
                'product_type',
                'order_status',
                'user_id',
                'organization_id'
            ],
            'message'
        ]);


        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('order_units', [
            'id' => $response->decodeResponseJson()['data']['id'],
        ]);

    }

    public function test_agreement_order()
    {
        $model = AgreementOrder::factory()->create();

        $this->assertNotNull($model);
    }

    public function test_agreement_order_accept()
    {
        $model = AgreementOrderAccept::factory()->create();

        $this->assertNotNull($model);
    }

    /**
     * Тестироование логики работы интерактора когда только главный заказ (2 адресса доставки)
     */
    public function test_create_order_interactor_one_Address()
    {
        $interactor = app(CreateOrderUnitInteractor::class);

        /**
        * @var Address
        */
        $Addresses = Address::factory()->count(2)->create();

        /**
        * @var Organization
        */
        $organization = Organization::factory()->create();

        $order = $interactor->execute(
            OrderUnitCreateDTO::make(
                start_Address_id: $Addresses[0]->id,
                end_Address_id: $Addresses[1]->id,
                start_date_delivery: now(),
                end_date_delivery: now(),
                organization_id: $organization->id,
                end_date_order: now(),
                type_load_truck: "ftl",
                order_total: 80000,
                Address_array: null,
                product_type: 'Печеньки',
                body_volume: 70,
                order_status: null,
                user_id: $organization->owner_id,
                contractors_id: null,
                description: 'Test description',
            )
        )->refresh();

        $this->assertNotNull($order);
        $this->assertIsArray($order->addresses->toArray());
        $this->assertNotEmpty($order->addresses->toArray());
    }

     /**
     * Тестироование логики работы интерактора когда главный заказ + (2 адресса) + множество других
     */
    public function test_create_order_interactor_many_Address()
    {
        $interactor = app(CreateOrderUnitInteractor::class);

        /**
        * @var Address
        */
        $Addresses = Address::factory()->count(4)->create();

        /**
        * @var Organization
        */
        $organization = Organization::factory()->create();


        /**
        * @var OrderUnit
        */
        $order = $interactor->execute(
            OrderUnitCreateDTO::make(
                start_Address_id: $Addresses[0]->id,
                end_Address_id: $Addresses[1]->id,
                start_date_delivery: now(),
                end_date_delivery: now(),
                organization_id: $organization->id,
                end_date_order: now(),
                type_load_truck: "ltl",
                order_total: 80000,
                Address_array: [
                    ["{$Addresses[2]->id}" => now(),],
                    ["{$Addresses[3]->id}" => now(),],
                ],
                product_type: 'Печеньки',
                body_volume: 70,
                order_status: null,
                user_id: $organization->owner_id,
                contractors_id: null,
                description: 'Test description',
            )
        )->refresh();


        $this->assertNotNull($order);
        $this->assertIsArray($order->addresses->toArray());
        $this->assertNotEmpty($order->addresses->toArray());
    }

    public function test_service_AgreementOrderAcceptService(): void
    {

    }
}
