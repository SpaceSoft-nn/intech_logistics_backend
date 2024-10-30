<?php

namespace App\Modules\OrderUnit\Common\Tests\Unit;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Interactor\Order\CreateOrderUnitInteractor;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Services\AgreementOrderAcceptService;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;

use App\Modules\User\Domain\Models\User;
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

        // Создаем мок для CreateOrderUnitInteractor
        $createOrderUnitInteractorMock = Mockery::mock(CreateOrderUnitInteractor::class);

        /**
        * указываем IDE что $orderMock - это OrderUnitRepository - явно
        * @var OrderUnitRepository $orderMock
        * @var CreateOrderUnitInteractor $createOrderUnitInteractorMock
        */
        // Создаем инстанс сервиса
        $orderService = new OrderUnitService($orderMock,  $createOrderUnitInteractorMock);

        // Вызываем метод сервиса
        $sum = $orderService->calcultTotalOrders(['uuid1', 'uuid2', 'uuid3']);


        // Проверяем, что метод правильно вычислил сумму
        $this->assertEquals(100, $sum);

    }

    public function test_service_order_unit_calcultBodyVolumeOrders(): void
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

        // Создаем мок для CreateOrderUnitInteractor
        $createOrderUnitInteractorMock = Mockery::mock(CreateOrderUnitInteractor::class);

        /**
        * указываем IDE что $orderMock - это OrderUnitRepository - явно
        * @var OrderUnitRepository $orderMock
        * @var CreateOrderUnitInteractor $createOrderUnitInteractorMock
        */
        // Создаем инстанс сервиса
        $orderService = new OrderUnitService($orderMock, $createOrderUnitInteractorMock);

        // Вызываем метод сервиса
        $sum = $orderService->calcultBodyBolumeOrders(['uuid1', 'uuid2', 'uuid3']);


        // Проверяем, что метод правильно вычислил сумму
        $this->assertEquals(55, $sum);

    }

    public function test_service_AgreementOrderAcceptService() : void
    {

        /**
        * @var AgreementOrderAccept
        */
        $agreementOrderAccept = AgreementOrderAccept::factory()->create([
            'contractor_bool' => false,
            'order_bool' => false,
        ]);

        /**
        * @var OrderUnit
        */
        $order = $agreementOrderAccept->agreement->order;

        /**
        * @var AgreementOrderAcceptService
        */
        $service = app(AgreementOrderAcceptService::class);

        //если user не связан с логикой AgreementOrder
        {
            /**
            * @var User
            */
            $user = User::factory()->create();

            $result = $service->acceptAgreement($user, $agreementOrderAccept);

            $this->assertFalse($result->status);
            $this->assertEquals('У данного пользователя нет прав на согласования заказа.', $result->message);
        }

        //если user связан с логикой AgreementOrder
        {
            //Заказчик
            {
                /**
                * @var User
                */
                $user = $order->user;

                $result = $service->acceptAgreement($user, $agreementOrderAccept);

                $this->assertTrue($result->status);
                $this->assertEquals('Заказчик успешно согласовал выполнение заказа.', $result->message);

                //проверяем что данные изменились
                $this->assertDatabaseHas('agreement_orders_accepts', [
                    'id' => $agreementOrderAccept->id,
                    'order_bool' => true,
                ]);

            }

            //Подрядчик
            {
                /**
                * @var User
                */
                $user = User::find($order->contractor->owner_id);

                $result = $service->acceptAgreement($user, $agreementOrderAccept);

                $this->assertTrue($result->status);
                $this->assertEquals('Подрядчик успешно согласовал выполнение заказа.', $result->message);

                //проверяем что данные изменились
                $this->assertDatabaseHas('agreement_orders_accepts', [
                    'id' => $agreementOrderAccept->id,
                    'contractor_bool' => true,
                ]);

            }

        }


    }

    // Очищаем Mockery после теста
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
