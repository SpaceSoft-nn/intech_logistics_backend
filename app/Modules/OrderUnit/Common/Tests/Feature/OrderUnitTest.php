<?php

namespace App\Modules\OrderUnit\Common\Tests\Feature;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\InteractorModules\AdressOrder\App\Data\DTO\OrderToAdressDTO;
use App\Modules\InteractorModules\AdressOrder\App\Data\Enum\TypeStateAdressEnum;
use App\Modules\InteractorModules\AdressOrder\Domain\Actions\LinkOrderToAdressAction;
use App\Modules\OrderUnit\Domain\Actions\LinkOrderUnitToCargoUnitAction;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
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
        $this->assertNotNull($orderUnit->adresses->toArray(), 'Коллекция OrderUnit не должна быть null.');

        // Проверяем, что это экземпляр Illuminate\Support\Collection
        $this->assertInstanceOf(Collection::class, $orderUnit->adresses, 'OrderUnit должна быть коллекцией.');

        // Проверяем, что в коллекции ровно 2 элемента
        $this->assertCount(2, $orderUnit->adresses->toArray(), 'Коллекция OrderUnit должна содержать ровно 2 элемента.');
    }
}
