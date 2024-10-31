<?php

namespace App\Modules\Address\App\Data\DTO\ValueObject;

use App\Modules\Address\App\Data\Enums\TypeAddressEnum;
use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
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
        public ?TypeAddressEnum $type_address,
        public ?string $apartament,
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
        ?string $apartament = null,
        ?string $house_number = null,
        ?string $postal_code = null,
        ?TypeAddressEnum $type_address = null,

    ) : self {

        return new self(

            region: $region,
            city: $city,
            street: $street,
            building: $building,
            apartament: $apartament,
            house_number: $house_number,
            postal_code: $postal_code,
            type_address: $type_address,
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
            "apartament" => $this->apartament,
            "house_number" => $this->house_number,
            "postal_code" => $this->postal_code,
            "type_address" => $this->type_address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }

    public static function returnObjectFromArray(array $array) : self
    {
        return new self(
            region: Arr::get($array, 'region', null),
            city: Arr::get($array, 'city', null),
            street: Arr::get($array, 'street', null),
            building: Arr::get($array, 'building', null),
            apartament: Arr::get($array, 'apartament', null),
            house_number: Arr::get($array, 'house_number', null),
            postal_code: Arr::get($array, 'postal_code', null),
            type_address: Arr::get($array, 'type_address', null),
            latitude: Arr::get($array, 'latitude', null),
            longitude: Arr::get($array, 'longitude', null),
        );
    }

}
