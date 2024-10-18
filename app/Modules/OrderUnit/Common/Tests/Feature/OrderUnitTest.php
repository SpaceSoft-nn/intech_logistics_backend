<?php

namespace App\Modules\OrderUnit\Common\Tests\Feature;

use App\Modules\OrderUnit\Domain\Actions\LinkOrderUnitToCargoUnitAction;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_unit_factory()
    {
        $orderUnits = OrderUnit::factory()->create();

        dd($orderUnits);

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
     * @return [type]
     */
    public function test_action_manyToMany_orderUnit_andCargoUnit()
    {
        $orderUnits = OrderUnit::factory()->create();
        $cargoUnit = CargoUnit::factory()->create();
        $status = LinkOrderUnitToCargoUnitAction::run($orderUnits, $cargoUnit);

        $this->assertTrue($status);
    }
}
