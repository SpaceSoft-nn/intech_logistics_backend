<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;


class RentagleArrayVO
{
    public function __construct(
        public readonly string|float $startLat,
        public readonly string|float $startLng,
        public readonly string|float $endLat,
        public readonly string|float $endLng,
    ) { }

    /**
     * Функция создания DTO
     * @param OrderUnit $order - Ожидание ведущий/главный заказ
     */
    public static function make(

        OrderUnit $order,

    ) : self {

        //Получаем репозиторий с работой промежуточной таблицы Adress/OrderUnit
        $rep = app(OrderUnitRepository::class);

        //Получаем начальный адрес отправки и конечненый (логика задана по приоритетности)
        $adress_start = $rep->firstPivotPriorityAdress($order);
        $adress_end = $rep->lastPivotPriorityAdress($order);

        return new self(
            startLat: $adress_start->latitude,
            startLng: $adress_start->longitude,
            endLat: $adress_end->latitude,
            endLng: $adress_end->longitude,
        );

    }

}
