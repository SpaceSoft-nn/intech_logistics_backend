<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Interactor\Order\CreateOrderUnitInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Exception;
use Illuminate\Support\Collection;

class OrderUnitService
{

    public function __construct(
        public OrderUnitRepository $repOrder,
        public CreateOrderUnitInteractor $createOrderUnitInteractor,
    ) {}

    public function createOrderUnit(OrderUnitCreateDTO $dto) : ?OrderUnit
    {
        return $this->createOrderUnitInteractor->execute($dto);
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

        $arrayOrders = $arr;

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

        if( !($arr instanceof Collection) ) { $arrayOrders = $this->repOrder->getAll($arr); }

        $arrayOrders = $arr;

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
}
