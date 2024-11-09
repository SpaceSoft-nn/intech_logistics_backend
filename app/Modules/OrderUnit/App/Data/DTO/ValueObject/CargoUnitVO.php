<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class CargoUnitVO implements Arrayable
{

    public function __construct(

        public readonly string $pallets_space,
        public readonly bool $customer_pallets_space,

    ) {}

    public static function make(

        string $pallets_space,
        bool $customer_pallets_space,


    ) : self {

        return new self(

            pallets_space : $pallets_space,
            customer_pallets_space: $customer_pallets_space,

        );

    }


    public function toArray() : array
    {
        return [
            "pallets_space" => $this->pallets_space ,
            "customer_pallets_space" => $this->customer_pallets_space ,
        ];
    }
}
