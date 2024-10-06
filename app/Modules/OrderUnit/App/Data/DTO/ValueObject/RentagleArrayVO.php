<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

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
        return new self(
            startLat: $order->adress_start->latitude,
            startLng: $order->adress_start->longitude,
            endLat: $order->adress_end->latitude,
            endLng: $order->adress_end->longitude,
        );
    }

}
