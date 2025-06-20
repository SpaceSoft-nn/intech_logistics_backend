<?php

namespace App\Modules\Tender\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\Tender\App\Data\Enums\TypeTenderEnum;
use Illuminate\Contracts\Support\Arrayable;
use Arr;

final readonly class LotTenderVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $general_count_transport,
        public float $price_for_km,
        public float $body_volume_for_order,

        public TypeTransportWeight $type_transport_weight,
        public TypeLoadingTruckMethod $type_load_truck,
        public TypeTenderEnum $type_tender,

        public string $date_start,
        public int $period,
        public string $organization_id,

        public ?StatusTenderEnum $status_tender,
    ) {}



    //устанавливаем статус тендер, получаем новый объект VO
    public function setStatusTender(StatusTenderEnum $status_tender): self
    {
        return $this->make(
            general_count_transport: $this->general_count_transport,
            price_for_km: $this->price_for_km,
            body_volume_for_order: $this->body_volume_for_order,
            type_transport_weight: TypeTransportWeight::objectValueToStringCaseName($this->type_transport_weight),
            type_load_truck: TypeLoadingTruckMethod::objectValueToStringCaseName($this->type_load_truck),
            date_start: $this->date_start,
            period: $this->period,
            organization_id: $this->organization_id,
            type_tender: TypeTenderEnum::objectValueToStringCaseName($this->type_tender),
            status_tender: $status_tender,
        );
    }


    public static function make(

        string $general_count_transport,
        float $price_for_km,
        float $body_volume_for_order,
        string $type_transport_weight,
        string $type_load_truck,
        string $date_start,
        int $period,
        string $organization_id,
        string $type_tender,

        ?StatusTenderEnum $status_tender = null,

    ) : self {

        return new self(
            general_count_transport: $general_count_transport,
            price_for_km: $price_for_km,
            body_volume_for_order: $body_volume_for_order,

            type_transport_weight: TypeTransportWeight::stringByCaseToObject($type_transport_weight),
            type_load_truck: TypeLoadingTruckMethod::stringByCaseToObject($type_load_truck),
            type_tender: TypeTenderEnum::stringByCaseToObject($type_tender),

            date_start: $date_start,
            period: $period,
            organization_id: $organization_id,

            status_tender: $status_tender,
        );

    }


    public function toArray() : array
    {
        return [
            "general_count_transport" => $this->general_count_transport,
            "price_for_km" => $this->price_for_km,

            "body_volume_for_order" => $this->body_volume_for_order,
            "type_transport_weight" => $this->type_transport_weight,
            "type_tender" => $this->type_tender,

            "type_load_truck" => $this->type_load_truck,
            "date_start" => $this->date_start,
            "period" => $this->period,
            "organization_id" => $this->organization_id,

            "status_tender" => $this->status_tender,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            general_count_transport: Arr::get($data, 'general_count_transport'),
            price_for_km: Arr::get($data, 'price_for_km'),
            body_volume_for_order: Arr::get($data, 'body_volume_for_order'),
            type_transport_weight: Arr::get($data, 'type_transport_weight'),
            type_load_truck: Arr::get($data, 'type_load_truck'),
            type_tender: Arr::get($data, 'type_tender'),

            date_start: Arr::get($data, 'date_start'),
            period: Arr::get($data, 'period'),
            organization_id: Arr::get($data, 'organization_id'),

            status_tender: Arr::get($data, 'status_tender', null),
        );
    }

}
