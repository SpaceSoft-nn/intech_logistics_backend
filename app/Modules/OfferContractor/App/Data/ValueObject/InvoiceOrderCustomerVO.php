<?php

namespace App\Modules\OfferContractor\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

readonly class InvoiceOrderCustomerVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public float $order_total, #TODO Добавить класс для работы с деньгами
        public float $body_volume,
        public string $type_product,
        public TransportTypeWeight $type_transport_weight,
        public TransportLoadingType $type_load_truck,
        public string $start_address_id,
        public string $end_address_id,
        public string $start_date,
        public string $end_date,
        public ?string $description,

    ) {}

    public static function make(
        float $order_total,
        float $body_volume,
        string $type_product,
        string $type_transport_weight,
        string $type_load_truck,
        string $start_address_id,
        string $end_address_id,
        string $start_date,
        string $end_date,
        ?string $description = null,

    ) : self {


        return new self(
            order_total: $order_total,
            body_volume: $body_volume,
            type_product: $type_product,
            type_transport_weight: TransportTypeWeight::stringByCaseToObject($type_transport_weight),
            type_load_truck: TransportLoadingType::stringByCaseToObject($type_load_truck),
            start_address_id: $start_address_id,
            end_address_id: $end_address_id,
            start_date: $start_date,
            end_date: $end_date,
            description: $description,
        );

    }

    public function toArray() : array
    {
        return [
            "order_total" => $this->order_total,
            "body_volume" => $this->body_volume,
            "type_product" => $this->type_product,
            "type_transport_weight" => $this->type_transport_weight,
            "type_load_truck" => $this->type_load_truck,
            "start_address_id" => $this->start_address_id,
            "end_address_id" => $this->end_address_id,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "description" => $this->description,
        ];
    }

    public static function fromArrayToObject(array $data) : self
    {
        return self::make(
            order_total : Arr::get($data, "order_total"),
            body_volume : Arr::get($data, "body_volume"),
            type_product : Arr::get($data, "type_product"),
            type_transport_weight : Arr::get($data, "type_transport_weight"),
            type_load_truck : Arr::get($data, "type_load_truck"),
            start_address_id : Arr::get($data, "start_address_id"),
            end_address_id : Arr::get($data, "end_address_id"),
            start_date : Arr::get($data, "start_date"),
            end_date : Arr::get($data, "end_date"),
            description : Arr::get($data, "description", null),
        );
    }
}
