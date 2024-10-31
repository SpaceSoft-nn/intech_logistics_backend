<?php

namespace App\Modules\Transfer\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class TransferVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

            public readonly string $transport_id,
            public readonly string $delivery_start,
            public readonly string $delivery_end,
            public readonly string $Address_start_id,
            public readonly string $Address_end_id,
            public readonly string $order_total,
            public readonly string $description,
            public readonly string $body_volume,

    ) {}

    public static function make(

        string $transport_id,
        string $delivery_start,
        string $delivery_end,
        string $Address_start_id,
        string $Address_end_id,
        string $order_total,
        string $description,
        string $body_volume,

    ) : self {
        return new self(
            transport_id: $transport_id,
            delivery_start: $delivery_start,
            delivery_end: $delivery_end,
            Address_start_id: $Address_start_id,
            Address_end_id: $Address_end_id,
            order_total: $order_total,
            description: $description,
            body_volume: $body_volume,
        );
    }

    public function toArray() : array
    {
        return [
            "body_volume" => $this->body_volume,
            "transport_id" => $this->transport_id,
            "delivery_start" => $this->delivery_start,
            "delivery_end" => $this->delivery_end,
            "Address_start_id" => $this->Address_start_id,
            "Address_end_id" => $this->Address_end_id,
            "order_total" => $this->order_total,
            "description" => $this->description,
            "body_volume" => $this->body_volume,
        ];
    }

}
