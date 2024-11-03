<?php

namespace App\Modules\OrderUnit\App\Data\DTO\OrderUnit;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use Illuminate\Contracts\Support\Arrayable;

class OrderUnitCreateDTO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public readonly string $start_address_id,
        public readonly string $end_address_id,
        public readonly string $start_date_delivery,
        public readonly string $end_date_delivery,
        public readonly string $organization_id,
        public readonly string $end_date_order,
        public readonly string $type_load_truck,
        public readonly int $order_total, #TODO Учитывать работу с деньгами
        public ?array $address_array,
        public ?string $product_type,
        public ?int $body_volume,
        public ?StatusOrderUnitEnum $order_status = StatusOrderUnitEnum::draft,
        public ?string $user_id,
        public ?string $contractors_id,
        public ?string $description,

    ) {}

    public static function make(

        string $start_address_id,
        string $end_address_id,
        string $start_date_delivery,
        string $end_date_delivery,
        string $organization_id,
        string $end_date_order,
        int $order_total,
        string $type_load_truck,
        ?string $user_id = null,
        ?string $contractors_id = null,
        ?string $product_type = null,
        ?int $body_volume = null,
        ?StatusOrderUnitEnum $order_status = null,
        ?string $description= null,
        ?array $address_array = null, // Учесть если у нас будет массив адрессов

    ) : self {

        return new self(
            start_address_id: $start_address_id,
            end_address_id: $end_address_id,
            start_date_delivery: $start_date_delivery,
            end_date_delivery: $end_date_delivery,
            organization_id: $organization_id,
            end_date_order: $end_date_order,
            product_type: $product_type,
            body_volume: $body_volume,
            type_load_truck: $type_load_truck,
            order_total: $order_total,
            description: $description,
            order_status: $order_status,
            user_id: $user_id,
            contractors_id: $contractors_id,
            address_array: $address_array,
        );

    }

    public function toArray() : array
    {
        return [

            "start_address_id" => $this->start_address_id,
            "end_address_id" => $this->end_address_id,
            "start_date_delivery" => $this->start_date_delivery,
            "end_date_delivery" => $this->end_date_delivery,
            "organization_id" => $this->organization_id,
            "end_date_order" => $this->end_date_order,
            "product_type" => $this->product_type,
            "body_volume" => $this->body_volume,
            "type_load_truck" => $this->type_load_truck,
            "order_total" => $this->order_total,
            "description" => $this->description,
            "order_status" => $this->order_status,
            "user_id" => $this->user_id,
            "contractors_id" => $this->contractors_id,
            "address_array" => $this->address_array,

        ];
    }

}
