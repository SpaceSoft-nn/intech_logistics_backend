<?php

namespace App\Modules\OrderUnit\App\Repositories;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\OrderUnit\Domain\Models\OrderUnit as Model;

class OrderUnitRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    /**
     * Получаем последний адресс (прибытия) по приоритетности при связи orderUnit => adress
     * @param Model|int $order
     * @return
     */
    public function lastPivotPriorityAdress(Model|int $order) : ?Adress
    {

        if ($order instanceof Model) {

            $maxPriority = $order->addresses()->max('priority');

            $lastAddress = $order->addresses()
            ->wherePivot('priority', $maxPriority)
            ->first();

        } else {

            $order = $this->query()->find($order);

            $maxPriority = $order->addresses()->max('priority');

            $lastAddress = $order->addresses()
            ->wherePivot('priority', $maxPriority)
            ->first();
        }



        return $lastAddress;
    }

    /**
     * Получаем первый адресс (отправки) по приоритетности при связи orderUnit => adress
     * @return ?Adress
     */
    public function firstPivotPriorityAdress(Model|int $order) : ?Adress
    {
        if($order instanceof Model){

            $minPriority = $order->addresses()->min('priority');

            $firstAddress = $order->addresses()
                                    ->wherePivot('priority', $minPriority)
                                    ->first();

        } else {

            $order = $this->query()->find($order);

            if(!$order) { return null; }

            $minPriority = $order->addresses()->min('priority');

            $firstAddress = $order->addresses()
            ->wherePivot('priority', $minPriority)
            ->first();

        }

        return $firstAddress;
    }


}
