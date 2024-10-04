<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use Illuminate\Contracts\Support\Arrayable;

class OrderUnitVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public readonly string $delivery_start,
        public readonly string $delivery_end,
        public readonly string $adress_start_id,
        public readonly string $adress_end_id,
        public readonly string $body_volume,
        public readonly string $order_total,
        public readonly string $description,
        public readonly string $organization_id,
        public readonly string $mgx_id,
        public ?string $product_type,
        public ?StatusOrderUnitEnum $order_status,
        public ?string $user_id,

    ) {}

    public static function make(

        string $delivery_end,
        string $adress_start_id,
        string $adress_end_id,
        string $body_volume,
        string $order_total,
        string $description,
        string $organization_id,
        string $delivery_start,
        string $mgx_id,
        ?string $product_type = null,
        ?StatusOrderUnitEnum $order_status = null,
        ?string $user_id = null,

    ) : self {

        return new self(

            delivery_start: $delivery_start,
            delivery_end: $delivery_end,
            adress_start_id: $adress_start_id,
            adress_end_id: $adress_end_id,
            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,
            mgx_id: $mgx_id,
            product_type: $product_type,
            order_status: $order_status,
            user_id: $user_id,
            organization_id: $organization_id,

        );

    }


    public function toArray() : array
    {
        return [

            "delivery_start" => $this->delivery_start,
            "delivery_end" => $this->delivery_end,
            "adress_start_id" => $this->adress_start_id,
            "adress_end_id" => $this->adress_end_id,
            "body_volume" => $this->body_volume,
            "order_total" => $this->order_total,
            "description" => $this->description,
            "product_type" => $this->product_type,
            "order_status" => $this->order_status,
            "user_id" => $this->user_id,
            "organization_id" => $this->organization_id,
            "mgx_id" => $this->mgx_id,

        ];
    }
}
