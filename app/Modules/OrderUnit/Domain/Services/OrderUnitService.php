<?php

namespace App\Modules\OrderUnit\Domain\Services;

use Exception;
use Illuminate\Support\Collection;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\Domain\Interactor\Order\CreateOrderUnitInteractor;
use App\Modules\OrderUnit\Domain\Interactor\Order\UpdateDraftOrderUnitInteractor;
use App\Modules\OrderUnit\Domain\Interactor\Order\CreateOrderUnitHasTenderInteractor;

class OrderUnitService
{

    public function __construct(
        private OrderUnitRepository $repOrder,
        private CreateOrderUnitInteractor $createOrderUnitInteractor,
        private CreateOrderUnitHasTenderInteractor $сreateOrderUnitHasTenderInteractor,
        private UpdateDraftOrderUnitInteractor $updateDraftOrderUnitInteractor,

    ) {}

    public function createOrderUnit(OrderUnitCreateDTO $dto) : ?OrderUnit
    {
        //При Lot_tender
        if(!is_null($dto->orderUnitVO->lot_tender_id)){
            //Если в VO существует ссылка на lot_tender_id - выбираем бизнес логику по созданию lot_tender_id
            return $this->сreateOrderUnitHasTenderInteractor->execute($dto->orderUnitVO);
        }

        return $this->createOrderUnitInteractor->execute($dto);
    }

    /** Обновляем все возможные данные у заказа который в статусе 'черновик */
    public function updateDraftOrderUnit(OrderUnitCreateDTO $dto, OrderUnit $order) : OrderUnit
    {
        return $this->updateDraftOrderUnitInteractor->execute($dto, $order);
    }


    #TODO Вынести эту логику в отдельный класс
    /**
     * Подсчитывает сумму всех заказов
     * @param string[]|Collection<OrderUnit> $arr
     *
     * @return
     */
    public function calcultTotalOrders(array|Collection $arr) : float
    {
        $total = 0;

        if( !($arr instanceof Collection) ) { $arrayOrders = $this->repOrder->getAll($arr); }
        else {  $arrayOrders = $arr; }


        if($arrayOrders) {

            foreach ($arrayOrders as $order) {

                $price = trim($order->order_total); // Убираем пробелы по краям

                if (is_numeric($price)) {

                    $total += (float) $price; // Приводим к числу с плавающей точкой и добавляем к общей сумме
                } else {
                    throw new Exception('Не верный формат цены у Заказа.', 400);
                }
            }

        } else {

            throw new Exception('Заказы не были найдены.', 404);

        }

        return $total;
    }


    #TODO Вынести эту логику в отдельный класс
    /**
    * Подсчитывает сумму объёмов всех заказов
    * @param string[]|Collection<OrderUnit> $arr
    *
    * @return
    */
    public function calcultBodyBolumeOrders(array|Collection $arr) : float
    {

        $total = 0;

        if( !($arr instanceof Collection) ) {  $arrayOrders = $this->repOrder->getAll($arr); }
        else {  $arrayOrders = $arr; }


        if($arrayOrders) {

            foreach ($arrayOrders as $order) {

                $body_volume = trim($order->body_volume); // Убираем пробелы по краям
                if (is_numeric($body_volume)) {

                    $total += (float) $body_volume; // Приводим к числу с плавающей точкой и добавляем к общей сумме
                } else {
                    throw new Exception('Не верный формат цены у Заказа.', 400);
                }
            }

        } else {
            throw new Exception('Заказы не были найдены.', 404);
        }

        return $total;
    }

    //!!!!! В ЭТОМ МЕТОДЕ НЕТУ СМЫСЛА ОН НЕ УЧИТЫВАЕТ MGX
    #TODO Вынести эту логику в отдельный класс
    /**
     * Посчитать общий объём всек CargoGood для заказа
     * @param Collection<СargoGood> $arr
     *
     * @return [type]
     */
    public function calculateBodyVolumeOfCargoGood(Collection $arr) : float
    {
        $total = 0;

        if($arr) {

            foreach ($arr as $value) {

                $body_volume = trim($value->body_volume); // Убираем пробелы по краям
                if (is_numeric($body_volume)) {

                    $total += (float) $body_volume; // Приводим к числу с плавающей точкой и добавляем к общей сумме
                } else {
                    throw new Exception('Не верный формат объём у Груза.', 400);
                }
            }

        } else {
            throw new Exception('Заказы не были найдены.', 404);
        }

        return $total;
    }

    //!!!!! В ЭТОМ МЕТОДЕ НЕТУ СМЫСЛА ОН НЕ УЧИТЫВАЕТ MGX
    #TODO Вынести эту логику в отдельный класс
    /**
     * Посчитать общий объём всех паллетов для заказа в зависимости от грузов
     * @param Collection<СargoGood> $arr
     *
     * @return int
     */
    public function calculateCargoUnitsSumOfCargoGood(Collection $arr) : int
    {
        $total = 0;

        if($arr) {

            foreach ($arr as $value) {

                $cargo_units_count = trim($value->cargo_units_count); // Убираем пробелы по краям
                if (is_numeric($cargo_units_count)) {

                    $total += (float) $cargo_units_count; // Приводим к числу с плавающей точкой и добавляем к общей сумме
                } else {
                    throw new Exception('Не верный формат количества паллетов у Груза.', 400);
                }
            }

        } else {
            throw new Exception('Заказы не были найдены.', 404);
        }

        return $total;
    }
}
