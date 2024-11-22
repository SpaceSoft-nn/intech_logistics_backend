<?php

namespace App\Modules\Address\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class AddressVO implements Arrayable, JsonSerializable
{

    use FilterArrayTrait;

    public function __construct(
        public readonly string $region,
        public readonly string $city,
        public readonly string $street,


        public readonly string $latitude,
        public readonly string $longitude,

        public ?string $building,
        // public ?TypeAddressEnum $type_address,
        public ?string $postal_code,
        public ?array $json,
        public ?string $update_json,
    ) {}

    public static function make(

        string $region,
        string $city,
        string $street,

        string $latitude,
        string $longitude,


        ?string $building = null,
        ?string $postal_code = null,
        ?array $json = null,
        ?string $update_json = null,
        // ?TypeAddressEnum $type_address = null,

    ) : self {

        return new self(

            region: $region,
            city: $city,
            street: $street,
            building: $building,
            postal_code: $postal_code,
            // type_address: $type_address,
            latitude: $latitude,
            longitude: $longitude,
            json: $json,
            update_json: $update_json,

        );

    }

    public function toArray() : array
    {
        return [
            "region" => $this->region,
            "city" => $this->city,
            "street" => $this->street,
            "building" => $this->building,
            "postal_code" => $this->postal_code,
            // "type_address" => $this->type_address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "json" => $this->json,
            "update_json" => $this->update_json,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return json_encode($this->json);
    }

    public static function returnObjectFromArray(array $array) : self
    {

        $data = Arr::get($array, 'data.data');

        $building =  Arr::get($data, 'house_type_full', null) . ' ' . Arr::get($data, 'house', null); //создаём правильное название дома

        return new self(
            region: Arr::get($data, 'country'), //Сделано country т.к в city_with_type и street_with_type - могут значение повторяться
            city: Arr::get($data, 'city_with_type'),
            street: Arr::get($data, 'street_with_type'),
            building: $building,
            postal_code: Arr::get($data, 'postal_code', null),
            latitude: Arr::get($data, 'geo_lat'),
            longitude: Arr::get($data, 'geo_lon'),
            json: Arr::get($array, 'data', null),
            update_json: Arr::has($array, 'data') ? now() : null,
        );
    }

}
