<?php

namespace App\Modules\Transaport\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Transaport\App\Data\Enums\TransportStatusEnum;
use Illuminate\Contracts\Support\Arrayable;

class TrasportVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(
        public readonly string $type,
        public readonly string $brand_model,
        public readonly string $year,
        public readonly string $transport_number,
        public readonly string $body_volume,
        public readonly string $body_weight,
        public readonly TransportStatusEnum $type_status,
        public readonly string $driver_id,
        public readonly string $description,
        public ?string $organization_id,
    ) {}

    public static function make(
        string $type,
        string $brand_model,
        string $year,
        string $transport_number,
        string $body_volume,
        string $body_weight,
        TransportStatusEnum $type_status,
        string $driver_id,
        string $description,
        ?string $organization_id,
    ) : self
    {
        return new self(
            type: $type,
            brand_model: $brand_model,
            year: $year,
            transport_number: $transport_number,
            body_volume: $body_volume,
            body_weight: $body_weight,
            type_status: $type_status,
            organization_id: $organization_id,
            driver_id: $driver_id,
            description: $description,
        );
    }

    public function toArray() : array
    {
        return [
            "type" => $this->type,
            "brand_model" => $this->brand_model,
            "year" => $this->year,
            "transport_number" => $this->transport_number,
            "body_volume" => $this->body_volume,
            "body_weight" => $this->body_weight,
            "type_status" => $this->type_status,
            "organization_id" => $this->organization_id,
            "driver_id" => $this->driver_id,
            "description" => $this->description,
        ];

    }
}
