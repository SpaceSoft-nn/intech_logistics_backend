<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;

#TODO Вынести из Order modules
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

        //Получаем репозиторий с работой промежуточной таблицы Address/OrderUnit
        $rep = app(OrderUnitRepository::class);

        //Получаем начальный адрес отправки и конечненый (логика задана по приоритетности)
        $Address_start = $rep->firstPivotPriorityAddress($order);
        $Address_end = $rep->lastPivotPriorityAddress($order);

        return new self(
            startLat: $Address_start->latitude,
            startLng: $Address_start->longitude,
            endLat: $Address_end->latitude,
            endLng: $Address_end->longitude,
        );

    }

}
