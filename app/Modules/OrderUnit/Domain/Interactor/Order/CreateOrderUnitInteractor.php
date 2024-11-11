<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Order;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitCreateAction;
use App\Modules\OrderUnit\Domain\Interactor\OrderAddress\LinkOrderToAddressInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;
use Exception;

class CreateOrderUnitInteractor
{

    public function __construct(
        private LinkOrderToAddressInteractor $orderToAddressInteractor,
    ) { }

    public function execute(OrderUnitCreateDTO $dto) : ?OrderUnit
    {
        return $this->run($dto);
    }

    private function run(OrderUnitCreateDTO $dto) : ?OrderUnit
    {


        #TODO Нужно использовать паттерн цепочка обязаностей (handler)
        $order = DB::transaction(function($pdo) use($dto)  {

            /**
            * @var OrderUnitAddressDTO
            */
            $orderUnitAddressDTO = $dto->orderUnitAddressDTO;

            /**
             * Получаем созданный заказ
            * @var OrderUnit
            */
            $order = $this->createOrderUnit($dto->orderUnitVO);
            //Запускаем привязку аддресов
            $this->orderToAddressInteractor->execute($order, $orderUnitAddressDTO);

            dd($order->refresh()->toArray(), $order->addresses->toArray());

            return $order;
        });

        try {

            #TODO Нужно использовать паттерн цепочка обязаностей (handler)
            $order = DB::transaction(function($pdo) use($dto)  {

                /**
                 * Получаем созданный заказ
                * @var OrderUnit
                */
                $order = $this->createOrderUnit($dto->orderUnitVO);

                /**
                * @var OrderUnitAddressDTO
                */
                $orderUnitAddressDTO = $dto->orderUnitAddressDTO;

                $this->orderToAddressInteractor->execute($order, $orderUnitAddressDTO);

                dd($order, $order->addresses);

                return $order;
            });


        } catch (\Throwable $th) {

            throw new Exception('Ошибка в CreateOrderUnitInteractor', 500);

        }

        return $order;
    }


    private function createOrderUnit(OrderUnitVO $vo) : ?OrderUnit
    {
        return OrderUnitCreateAction::make($vo);
    }


}
