<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Order;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitUpdateDraftAction;
use App\Modules\OrderUnit\Domain\Interactor\CargoGood\LinkOrderUnitToCargoGoodInteractor;
use App\Modules\OrderUnit\Domain\Interactor\OrderAddress\LinkOrderUnitToAddressInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;

class UpdateDraftOrderUnitInteractor
{
    public function __construct(
        private LinkOrderUnitToAddressInteractor $orderToAddressInteractor,
        private LinkOrderUnitToCargoGoodInteractor $orderToCargoGoodInteractor,
    ) { }

    public function execute(OrderUnitCreateDTO $dto, OrderUnit $order) : OrderUnit
    {
        return $this->run($dto, $order);
    }

    private function run(OrderUnitCreateDTO $dto, OrderUnit $order) : OrderUnit
    {

        /** @var ?OrderUnitVO */
        $orderUnitVO = $dto->orderUnitVO;

        /** @var ?OrderUnitAddressDTO */
        $orderUnitAddressDTO = $dto->orderUnitAddressDTO;

        /** @var ?array */
        $cargoGoodVO = $dto->cargoGoodVO;


        /**
        * @var OrderUnit
        */
        $order = DB::transaction(function($pdo) use(
            $orderUnitVO,
            $orderUnitAddressDTO,
            $cargoGoodVO,
            $order,
        )  {

            //Обновляем данные для сущности OrderUnit
            $order = $this->orderUnitUpdateDraftAction($orderUnitVO, $order);

            //обновляем адресса (пункт) - удаляем старый
            $this->updateAddressAction($orderUnitAddressDTO, $order);

            $this->updateCargoGood($cargoGoodVO, $order);

            //получаем актуальное состояние
            $order->refresh();

            return $order;

        });

        return $order;
    }


    private function orderUnitUpdateDraftAction(OrderUnitVO $vo, OrderUnit $order) :     OrderUnit
    {
        return OrderUnitUpdateDraftAction::make($vo, $order);
    }

    /**
     * Обновляем Адресса у заказа (удаляем старые сущности и связи)
     * @param OrderUnitAddressDTO $orderUnitAddressDTO
     * @param OrderUnit $order
     *
     * @return true
     */
    private function updateAddressAction(OrderUnitAddressDTO $orderUnitAddressDTO, OrderUnit $order) : bool
    {
        if($orderUnitAddressDTO !== null)
        {

            $start_address_id = $orderUnitAddressDTO->mainAddressVectorVO->start_address_id;
            $end_address_id = $orderUnitAddressDTO->mainAddressVectorVO->end_address_id;

            {
                foreach ($order->addresses as $address) {

                    if($address->id != $start_address_id && $address->id != $end_address_id){
                        //удаляем данные из таблицы
                        $address->delete();
                    }

                }

                //очищаем связи
                $order->addresses()->detach();
            }

            {   #TODO Проблема в том, что если адресса теже при обновлении что и были у Order, мы делаем лишний алгоритм и логику - надо в будущем предусмотреть при оптимизации это
                /**
                * @var OrderUnitAddressDTO
                */
                $orderUnitAddressDTO = $orderUnitAddressDTO;
                $this->orderToAddressInteractor->execute($order, $orderUnitAddressDTO);
            }

        }

        return true;
    }


    /**
     * Обновляем cargoGood удаляем сначала сущности, потом связи и создаём новые cargo_good
     * @param ?CargoGoodVO[] $cargoGoodVO
     * @param OrderUnit $order
     *
     * @return bool
     */
    private function updateCargoGood(?array $cargoGoodVO, OrderUnit $order) : bool
    {
        if(!empty($cargoGoodVO))
        {

            {
                foreach ($order->cargo_goods as $cargo_good) {
                    //удаляем данные из таблицы
                    $cargo_good->delete();
                }

                //очищаем связи
                $order->cargo_goods()->detach();
            }

            {
                //Создание CargoGoods[] и линковака с OrderUnit + Линковка с CargoUnit + валидация MGX и создание записей CargoUnit + уточнее слоёв Factory
                $this->orderToCargoGoodInteractor->execute($order, $cargoGoodVO);
            }

        }

        return true;
    }


}
