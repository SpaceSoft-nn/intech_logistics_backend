<?php

namespace App\Modules\Transport\App\Data\DTO\ValueObject;

use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;

class TransportationStatusСalendarVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $order_unit_id,
        public string $date,
        public string $enum_transportation_id,
        public string $transport_id,
        public string $address_id,

    ) {}

    public static function make(

        string $order_unit_id,
        string $date,
        string $enum_transportation_id,
        string $transport_id,
        string $address_id,


    ) : self{

        return new self(

            order_unit_id: $order_unit_id,
            date: $date,
            enum_transportation_id: $enum_transportation_id,
            transport_id: $transport_id,
            address_id: $address_id,

        );
    }

    public function toArray() : array
    {
        return [

            "order_unit_id" => $this->order_unit_id,
            "date" => $this->date,
            "enum_transportation_id" => $this->enum_transportation_id,
            "transport_id" => $this->transport_id,
            "address_id" => $this->address_id,

        ];

    }


}
