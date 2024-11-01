<?php

namespace App\Modules\InteractorModules\AddressOrder\App\Data\DTO;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;

class OrderToAddressDTO
{
    public function __construct(

        public Address $address,
        public OrderUnit $order,
        public TypeStateAddressEnum $type_status,
        public string $date,
        public ?int $priority = null,

    ) { }

    public static function make(

        Address $address,
        OrderUnit $order,
        TypeStateAddressEnum $type_status,
        string $date,
        ?int $priority = null,

    ) : self {

        return new self(
            address: $address,
            order: $order,
            type_status: $type_status,
            date: $date,
            priority: $priority,
        );

    }

}
