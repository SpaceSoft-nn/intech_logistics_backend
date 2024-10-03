<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class CargoUnitVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public readonly string $description,
        public  ?string $pallets_space_id,
        public  ?string $customer_pallets_space,

    ) {}

    public static function make(

        string $description,
        ?string $pallets_space_id,
        ?string $customer_pallets_space,

    ) : self {

        return new self(

            description : $description,
            pallets_space_id: $pallets_space_id,
            customer_pallets_space: $customer_pallets_space,

        );

    }


    public function toArray() : array
    {
        return [
            "description" => $this->description ,
            "pallets_space_id" => $this->pallets_space_id ,
            "customer_pallets_space" => $this->customer_pallets_space ,
        ];
    }
}
