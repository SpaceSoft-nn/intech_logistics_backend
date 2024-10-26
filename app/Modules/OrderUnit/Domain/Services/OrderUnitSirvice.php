<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class OrderUnitSirvice
{

    public function __construct(
        public OrderUnitRepository $repOrder,
    ) {}


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
