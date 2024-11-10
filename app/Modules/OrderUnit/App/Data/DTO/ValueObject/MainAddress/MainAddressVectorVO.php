<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\MainAddress;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Главный вектор движение (два Аддреса (две точки) создают вектор движения)
 */
class MainAddressVectorVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(


        public readonly string $start_address_id,
        public readonly string $end_address_id,
        public readonly string $start_date_delivery,
        public readonly string $end_date_delivery,


    ) {}

    public static function make(

        string $start_address_id,
        string $end_address_id,
        string $start_date_delivery,
        string $end_date_delivery,


    ) : self {

        return new self(
            start_address_id: $start_address_id,
            end_address_id: $end_address_id,
            start_date_delivery: $start_date_delivery,
            end_date_delivery: $end_date_delivery,
        );

    }

    public function toArray() : array
    {
        return [

            "start_address_id" => $this->start_address_id,
            "end_address_id" => $this->end_address_id,
            "start_date_delivery" => $this->start_date_delivery,
            "end_date_delivery" => $this->end_date_delivery,

        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        $start_address_id = Arr::get($data, "start_address_id");
        $end_address_id = Arr::get($data, "start_address_id");
        $start_date_delivery = Arr::get($data, "start_address_id");
        $end_date_delivery = Arr::get($data, "start_address_id");


        return static::make(
            start_address_id: $start_address_id ,
            end_address_id: $end_address_id ,
            start_date_delivery: $start_date_delivery,
            end_date_delivery: $end_date_delivery ,
        );
    }

}
