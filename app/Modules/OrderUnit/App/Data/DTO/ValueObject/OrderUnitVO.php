<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use Illuminate\Contracts\Support\Arrayable;

class OrderUnitVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(


        public readonly string $body_volume,
        public readonly string $order_total,
        public readonly string $description,
        public readonly string $organization_id,
        public ?string $end_date,
        public ?string $product_type,
        public ?StatusOrderUnitEnum $order_status,
        public ?string $user_id,

    ) {}

    public static function make(


        string $body_volume,
        string $order_total,
        string $description,
        string $organization_id,
        ?string $end_date = null,
        ?string $product_type = null,
        ?StatusOrderUnitEnum $order_status = null,
        ?string $user_id = null,

    ) : self {

        return new self(

            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,
            end_date: $end_date,
            product_type: $product_type,
            order_status: $order_status,
            user_id: $user_id,
            organization_id: $organization_id,

        );

    }


    public function toArray() : array
    {
        return [

            "end_date" => $this->end_date,
            "body_volume" => $this->body_volume,
            "order_total" => $this->order_total,
            "description" => $this->description,
            "product_type" => $this->product_type,
            "order_status" => $this->order_status,
            "user_id" => $this->user_id,
            "organization_id" => $this->organization_id,

        ];
    }
}
