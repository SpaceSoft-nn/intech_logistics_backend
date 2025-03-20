<?php

namespace App\Modules\Tender\App\Data\DTO;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;

final readonly class UpdateLotTenderDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public ?string $general_count_transport,
        public ?string $price_for_km,
        public ?string $body_volume_for_order,
        public ?StatusTenderEnum $status_tender,
        public ?TypeTransportWeight $type_transport_weight,
        public ?TypeLoadingTruckMethod $type_load_truck,

    ) { }

    public static function make(

        ?string $general_count_transport = null,
        ?string $price_for_km = null,
        ?string $body_volume_for_order = null,
        ?string $status_tender = null,
        ?string $type_transport_weight = null,
        ?string $type_load_truck = null,

    ) : self {

        return new self(
            general_count_transport: $general_count_transport,
            price_for_km: $price_for_km,
            body_volume_for_order: $body_volume_for_order,
            status_tender: $status_tender ? StatusTenderEnum::stringByCaseToObject($status_tender) : $status_tender,
            type_transport_weight: $type_transport_weight ? TypeTransportWeight::stringByCaseToObject($type_transport_weight) : $type_transport_weight,
            type_load_truck: $type_load_truck ? TypeLoadingTruckMethod::stringByCaseToObject($type_load_truck) : $type_load_truck,
        );

    }

    public function toArray()
    {
        return [

            "general_count_transport" => $this->general_count_transport,
            "price_for_km" => $this->price_for_km,
            "body_volume_for_order" => $this->body_volume_for_order,
            "status_tender" => $this->status_tender,
            "type_transport_weight" => $this->type_transport_weight,
            "type_load_truck" => $this->type_load_truck,

        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            general_count_transport: Arr::get($data, 'general_count_transport', null),
            price_for_km: Arr::get($data, 'price_for_km', null),
            body_volume_for_order: Arr::get($data, 'body_volume_for_order', null),
            status_tender: Arr::get($data, 'status_tender', null),
            type_transport_weight: Arr::get($data, 'type_transport_weight', null),
            type_load_truck: Arr::get($data, 'type_load_truck', null),
        );
    }


}
