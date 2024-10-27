<?php

namespace App\Modules\OrderUnit\Common\Tests\Unit;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Services\OrderUnitSirvece;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase;
use Mockery;

class OrderUnitTest extends TestCase
{

    public function test_service_order_unit_calcultTotalOrder(): void
    {

        $orderMock = Mockery::mock('alias:' . OrderUnitRepository::class)->makePartial();

        // Настраиваем ожидания от метода findOrdersByUuids
        $orderMock->shouldReceive('getAll')
            ->with(['uuid1', 'uuid2', 'uuid3'])  // Ожидаем конкретные UUID
            ->andReturn(new Collection([
                (object) ['order_total' => 50],       // Возвращаемую коллекцию данных
                (object) ['order_total' => 30],
                (object) ['order_total' => 20]
            ]));

        /**
        * указываем IDE что $orderMock - это OrderUnitRepository - явно
        * @var OrderUnitRepository $orderMock
        */
        // Создаем инстанс сервиса
        $orderService = new OrderUnitSirvece($orderMock);

        // Вызываем метод сервиса
        $sum = $orderService->calcultTotalOrders(['uuid1', 'uuid2', 'uuid3']);


        // Проверяем, что метод правильно вычислил сумму
        $this->assertEquals(100, $sum);

    }

    public function test_service_order_unit_calcultBodyBolumeOrders(): void
    {

        $orderMock = Mockery::mock('alias:' . OrderUnitRepository::class)->makePartial();

        // Настраиваем ожидания от метода findOrdersByUuids
        $orderMock->shouldReceive('getAll')
            ->with(['uuid1', 'uuid2', 'uuid3'])  // Ожидаем конкретные UUID
            ->andReturn(new Collection([
                (object) ['body_volume' => 20],       // Возвращаемую коллекцию данных
                (object) ['body_volume' => 20],
                (object) ['body_volume' => 15]
            ]));

        /**
        * указываем IDE что $orderMock - это OrderUnitRepository - явно
        * @var OrderUnitRepository $orderMock
        */
        // Создаем инстанс сервиса
        $orderService = new OrderUnitSirvece($orderMock);

        // Вызываем метод сервиса
        $sum = $orderService->calcultBodyBolumeOrders(['uuid1', 'uuid2', 'uuid3']);


        // Проверяем, что метод правильно вычислил сумму
        $this->assertEquals(55, $sum);

    }

    // Очищаем Mockery после теста
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
