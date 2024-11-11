<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Order;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitCreateAction;
use App\Modules\OrderUnit\Domain\Interactor\OrderAddress\LinkOrderUnitToAddressInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;
use Exception;

use function App\Helpers\Mylog;

class CreateOrderUnitInteractor
{

    public function __construct(
        private LinkOrderUnitToAddressInteractor $orderToAddressInteractor,
    ) { }

    public function execute(OrderUnitCreateDTO $dto) : ?OrderUnit
    {
        return $this->run($dto);
    }

    private function run(OrderUnitCreateDTO $dto) : ?OrderUnit
    {

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

                return $order->refresh();
            });


        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {

            $message = $th->getMessage();

            Mylog('Ошибка в CreateOrderUnitInteractor: при ModelNotFoundException ' . $th);
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException($message, 404);
        }
        catch (\Throwable $th) {
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
