<?php

namespace App\Modules\Address\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final readonly class AddressVO implements Arrayable, JsonSerializable
{

    use FilterArrayTrait;

    public function __construct(
        public readonly string $region,
        public readonly string $city,
        public readonly string $street,
        public readonly ?string $nomination,


        public readonly string $latitude,
        public readonly string $longitude,

        public ?string $building,
        // public ?TypeAddressEnum $type_address,
        public ?string $postal_code,
        public ?array $json,
        public ?string $update_json,
        public ?string $point_name, //пункт


    ) {}

    public static function make(


        string $region,
        string $city,
        string $street,
        string $nomination,

        string $latitude,
        string $longitude,

        ?string $point_name = null,
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
            nomination: $nomination,
            point_name: $point_name,

        );

    }

    public function toArray() : array
    {
        return [
            "point_name" => $this->point_name,
            "region" => $this->region,
            "city" => $this->city,
            "street" => $this->street,
            "nomination" => $this->nomination,
            "building" => $this->building,
            "postal_code" => $this->postal_code,
            // "type_address" => $this->type_address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "json" => $this->json,
            "update_json" => $this->update_json,
        ];
    }

    public function setJson(array $json) : self
    {

        //повторное создание объекта... #TODO Придумать что можно сделать без доп создание объекта
        return $this->make(
            region: $this->region,
            city: $this->city,
            nomination: $this->nomination,
            street: $this->street,
            building: $this->building,
            postal_code: $this->postal_code,
            latitude: $this->latitude,
            longitude: $this->longitude,
            point_name: $this->point_name,
            json: $json,
            update_json: Arr::has($json, 'data') ? now() : null,
        );
    }

    public function jsonSerialize(): mixed
    {
        return json_encode($this->json);
    }

    public static function returnObjectFromArray(array $array) : self
    {

        $data = Arr::get($array, 'data');

        $building =  Arr::get($data, 'house', null);

        return new self(
            point_name: Arr::get($array, 'point_name', null),
            region: Arr::get($data, 'region') ?? Arr::get($data, 'country'), //Сделано country т.к в city_with_type и street_with_type - могут значение повторяться
            city: Arr::get($data, 'city'),
            street: Arr::get($data, 'street'),
            nomination: Arr::get($array, 'unrestricted_value', null),
            building: $building,
            postal_code: Arr::get($data, 'postal_code', null),
            latitude: Arr::get($data, 'geo_lat'),
            longitude: Arr::get($data, 'geo_lon'),
            json: null,
            update_json: null,
        );
    }

}
