<?php

namespace App\Modules\Adress\App\Data\DTO\ValueObject;

use App\Modules\Adress\App\Data\Enums\TypeAdressEnum;
use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class AdressVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(
        public readonly string $region,
        public readonly string $city,
        public readonly string $street,


        public readonly string $coordinates,


        public ?string $building,
        public ?TypeAdressEnum $type_adress,
        public ?string $apartment,
        public ?string $house_number,
        public ?string $postal_code,
    ) {}

    public static function make(

        string $region,
        string $city,
        string $street,
        string $coordinates,

        ?string $building = null,
        ?string $apartment = null,
        ?string $house_number = null,
        ?string $postal_code = null,
        ?TypeAdressEnum $type_adress = null,

    ) : self {

        return new self(

            region: $region,
            city: $city,
            street: $street,
            building: $building,
            apartment: $apartment,
            house_number: $house_number,
            postal_code: $postal_code,
            coordinates: $coordinates,
            type_adress: $type_adress,

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
            "coordinates" => $this->coordinates,
            "type_adress" => $this->type_adress,
        ];
    }

}
