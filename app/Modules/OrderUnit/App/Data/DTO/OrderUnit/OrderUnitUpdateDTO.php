<?php

namespace App\Modules\OrderUnit\App\Data\DTO\OrderUnit;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Contracts\Support\Arrayable;

class OrderUnitUpdateDTO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public readonly OrderUnit $order,
        public ?bool $change_price,
        public ?bool $change_time,
        public ?StatusOrderUnitEnum $order_status,

    ) {}

    public static function make(

        OrderUnit $order,
        bool $change_price = null,
        bool $change_time = null,
        string $order_status = null,

    ) : self {

        return new self(

            order : $order,
            change_price: $change_price,
            change_time: $change_time,
            order_status: StatusOrderUnitEnum::stringByCaseToObject($order_status),

        );

    }

    public function toArray() : array
    {
        return [
            "order" => $this->order,
            "change_price" => $this->change_price,
            "change_time" => $this->change_time,
            "order_status" => $this->order_status->value,
        ];
    }

}
