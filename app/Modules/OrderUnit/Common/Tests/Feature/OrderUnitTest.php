<?php

namespace App\Modules\OrderUnit\Common\Tests\Feature;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\InteractorModules\AdressOrder\App\Data\DTO\OrderToAdressDTO;
use App\Modules\InteractorModules\AdressOrder\App\Data\Enum\TypeStateAdressEnum;
use App\Modules\InteractorModules\AdressOrder\Domain\Actions\LinkOrderToAdressAction;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Actions\LinkOrderUnitToCargoUnitAction;
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
     * Проверяем работу линковки через промежуточную таблицу Adress + OrderUnit
     * @return void
     */
    public function test_link_adress_order()
    {
        $orderUnit = OrderUnit::factory()->create();
        $adress = Adress::factory()->count(2)->create();

        LinkOrderToAdressAction::run(OrderToAdressDTO::make($adress[0], $orderUnit, TypeStateAdressEnum::sending, add_time_random(now(), 0) ));
        LinkOrderToAdressAction::run(OrderToAdressDTO::make($adress[1], $orderUnit, TypeStateAdressEnum::coming, add_time_random(now(), 7) ));


        // Проверяем, что коллекция не null
        $this->assertNotNull($orderUnit->addresses->toArray(), 'Коллекция OrderUnit не должна быть null.');

        // Проверяем, что это экземпляр Illuminate\Support\Collection
        $this->assertInstanceOf(Collection::class, $orderUnit->addresses, 'OrderUnit должна быть коллекцией.');

        // Проверяем, что в коллекции ровно 2 элемента
        $this->assertCount(2, $orderUnit->addresses->toArray(), 'Коллекция OrderUnit должна содержать ровно 2 элемента.');
    }

    /**
     * Проверка работоспособности endpoint - создание OrderUnit
     * @return void
     */
    public function test_create_order_endpoint() : void
    {

        $adress = Adress::factory()->count(2)->create();

        $organization = Organization::factory()->create();

        // Данные для POST-запроса
        $postData = [
            "start_adress_id" => $adress[0]->id,
            "end_adress_id" => $adress[1]->id,
            "organization_id" =>  $organization->id,

            "end_date_order" => "25.10.2024",

            "product_type" => "Кукуруза",
            "body_volume" => "60",

            "type_load_truck" => "ltl",
            "order_total" => "10000",

            "description" => "9d3476dc-d456-4960-a227-6d7fd3facc2e"
        ];

        // Отправляем POST-запрос на ваш endpoint
        $response = $this->post('/api/orders', $postData);


        // Проверяем, что статус ответа 200 OK
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
}
