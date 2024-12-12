<?php

namespace App\Modules\Transport\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Transport\App\Data\Enums\TransportBodyType;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

class TransportVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $brand_model,
        public string $year,
        public string $transport_number,
        public string $body_volume,
        public string $body_weight,

        public TransportLoadingType $type_loading,
        public TransportTypeWeight $type_weight,
        public TransportBodyType $type_body,
        public TransportStatusEnum $type_status,


        public string $organization_id,
        public ?string $driver_id,
        public ?string $description,
    ) {}

    public static function make(

        string $brand_model,
        string $year,
        string $transport_number,
        string $body_volume,
        string $body_weight,

        string $type_loading,
        string $type_weight,
        string $type_body,
        string $type_status,

        string $organization_id,
        ?string $driver_id = null,
        ?string $description = null,

    ) : self{

        return new self(
            brand_model: $brand_model,
            year: $year,
            transport_number: $transport_number,
            body_volume: $body_volume,
            body_weight: $body_weight,

            type_loading: TransportLoadingType::stringByCaseToObject($type_loading),
            type_weight: TransportTypeWeight::stringByCaseToObject($type_weight),
            type_body: TransportBodyType::stringByCaseToObject($type_body),
            type_status: TransportStatusEnum::stringByCaseToObject($type_status),

            organization_id: $organization_id,
            driver_id: $driver_id,
            description: $description,
        );
    }

    public function toArray() : array
    {
        return [

            "brand_model" => $this->brand_model,
            "year" => $this->year,
            "transport_number" => $this->transport_number,
            "body_volume" => $this->body_volume,
            "body_weight" => $this->body_weight,

            "type_loading" => $this->type_loading,
            "type_weight" => $this->type_weight,
            "type_body" => $this->type_body,
            "type_status" => $this->type_status,

            "organization_id" => $this->organization_id,
            "driver_id" => $this->driver_id,
            "description" => $this->description,

        ];

    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            brand_model : Arr::get($data, "brand_model"),
            year : Arr::get($data, "year"),
            transport_number : Arr::get($data, "transport_number"),
            body_volume : Arr::get($data, "body_volume"),
            body_weight : Arr::get($data, "body_weight"),

            type_loading: Arr::get($data, "type_loading"),
            type_weight: Arr::get($data, "type_weight"),
            type_body: Arr::get($data, "type_body"),
            type_status : Arr::get($data, "type_status"),

            organization_id : Arr::get($data, "organization_id"),
            driver_id : Arr::get($data, "driver_id", null ),
            description : Arr::get($data, "description", null),
        );

    }
}
