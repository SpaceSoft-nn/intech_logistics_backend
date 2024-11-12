<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;
use Illuminate\Contracts\Support\Arrayable;

final readonly class CargoUnitVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public  TypeSizePalletSpaceEnum $pallets_space,
        public  bool $customer_pallets_space,

    ) {}

    public static function make(

        string $pallets_space,
        bool $customer_pallets_space,


    ) : self {

        return new self(

            pallets_space : TypeSizePalletSpaceEnum::stringValueToObject($pallets_space),
            customer_pallets_space: $customer_pallets_space,

        );

    }


    public function toArray() : array
    {
        return [
            "pallets_space" => $this->pallets_space?->value,
            "customer_pallets_space" => $this->customer_pallets_space,
        ];
    }
}
