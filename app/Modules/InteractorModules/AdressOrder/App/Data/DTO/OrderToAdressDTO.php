<?php

namespace App\Modules\InteractorModules\AdressOrder\App\Data\DTO;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\InteractorModules\AdressOrder\App\Data\Enum\TypeStateAdressEnum;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Support\Collection;

class OrderToAdressDTO
{
    public function __construct(

        public Adress $adress,
        public OrderUnit $order,
        public TypeStateAdressEnum $type_status,
        public string $date,

    ) { }

    public static function make(

        Adress $adress,
        OrderUnit $order,
        TypeStateAdressEnum $type_status,
        string $date,

    ) : self {

        return new self(
            adress: $adress,
            order: $order,
            type_status: $type_status,
            date: $date,
        );

    }

}
