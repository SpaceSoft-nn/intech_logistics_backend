<?php

namespace App\Modules\Address\App\Data\DTO\ValueObject;

use App\Modules\Address\App\Data\Enums\TypeAddressEnum;
use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class AddressVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(
        public readonly string $region,
        public readonly string $city,
        public readonly string $street,


        public readonly string $latitude,
        public readonly string $longitude,


        public ?string $building,
        public ?TypeAddressEnum $type_Address,
        public ?string $apartment,
        public ?string $house_number,
        public ?string $postal_code,
    ) {}

    public static function make(

        string $region,
        string $city,
        string $street,

        string $latitude,
        string $longitude,

        ?string $building = null,
        ?string $apartment = null,
        ?string $house_number = null,
        ?string $postal_code = null,
        ?TypeAddressEnum $type_Address = null,

    ) : self {

        return new self(

            region: $region,
            city: $city,
            street: $street,
            building: $building,
            apartment: $apartment,
            house_number: $house_number,
            postal_code: $postal_code,
            type_Address: $type_Address,
            latitude: $latitude,
            longitude: $longitude,

        );

    }

    public function toArray() : array
    {
        return [
            "region" => $this->region,
            "city" => $this->city,
            "street" => $this->street,
            "building" => $this->building,
            "apartment" => $this->apartment,
            "house_number" => $this->house_number,
            "postal_code" => $this->postal_code,
            "type_Address" => $this->type_Address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }

}
