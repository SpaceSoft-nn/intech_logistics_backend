<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Order;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitCreateAction;
use App\Modules\OrderUnit\Domain\Interactor\CargoGood\LinkOrderUnitToCargoGoodInteractor;
use App\Modules\OrderUnit\Domain\Interactor\OrderAddress\LinkOrderUnitToAddressInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;
use Exception;

use function App\Helpers\Mylog;

class CreateOrderUnitInteractor
{

    public function __construct(
        private LinkOrderUnitToAddressInteractor $orderToAddressInteractor,
        private LinkOrderUnitToCargoGoodInteractor $orderToCargoGoodInteractor,
    ) { }

    public function execute(OrderUnitCreateDTO $dto) : ?OrderUnit
    {
        return $this->run($dto);
    }

    private function run(OrderUnitCreateDTO $dto) : ?OrderUnit
    {
          /**
                * Получаем созданный заказ
                * @var OrderUnit
                */
                $order = $this->createOrderUnit($dto->orderUnitVO);


                { //Линковка заказа и Адрессов
                    /**
                    * @var OrderUnitAddressDTO
                    */
                    $orderUnitAddressDTO = $dto->orderUnitAddressDTO;
                    $this->orderToAddressInteractor->execute($order, $orderUnitAddressDTO);
                }


                //Нужно получать актуальное состояние что бы с ним работать корректно во стальных сервесах
                $order = $order->refresh();


                { //Создание CargoGoods[] и линковака с OrderUnit + Линковка с CargoUnit + валидация MGX и создание записей CargoUnit + уточнее слоёв Factory
                    $this->orderToCargoGoodInteractor->execute($order, $dto->cargoGoodVO);
                }


        try {

            #TODO Нужно использовать паттерн цепочка обязаностей (handler)
            /** @var OrderUnit */
            $order = DB::transaction(function($pdo) use($dto)  {

                /**
                * Получаем созданный заказ
                * @var OrderUnit
                */
                $order = $this->createOrderUnit($dto->orderUnitVO);


                { //Линковка заказа и Адрессов
                    /**
                    * @var OrderUnitAddressDTO
                    */
                    $orderUnitAddressDTO = $dto->orderUnitAddressDTO;
                    $this->orderToAddressInteractor->execute($order, $orderUnitAddressDTO);
                }


                //Нужно получать актуальное состояние что бы с ним работать корректно во стальных сервесах
                $order = $order->refresh();


                { //Создание CargoGoods[] и линковака с OrderUnit + Линковка с CargoUnit + валидация MGX и создание записей CargoUnit + уточнее слоёв Factory
                    $this->orderToCargoGoodInteractor->execute($order, $dto->cargoGoodVO);
                }

                return $order;

            });

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {

            $message = $th->getMessage();

            Mylog('Ошибка в CreateOrderUnitInteractor: при ModelNotFoundException ' . $th);
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException($message, 404);
        }
        catch (\App\Modules\Base\Error\BusinessException $th) {

            #TODO продумать что можно сделать, приходится отлавливать из нижнего сервеса что бы выдать правильную ошибку и сообщение
            $message = $th->getMessage();

            Mylog('Ошибка в CreateOrderUnitInteractor: при ModelNotFoundException ' . $th);
            throw $th;

        }
        catch (\Throwable $th) {

            $message = $th->getMessage();

            Mylog('Ошибка в CreateOrderUnitInteractor: ' . $th);
            throw new Exception('Ошибка в CreateOrderUnitInteractor', 500);

        }


        return $order;
    }


    private function createOrderUnit(OrderUnitVO $vo) : ?OrderUnit
    {
        return OrderUnitCreateAction::make($vo);
    }


}
