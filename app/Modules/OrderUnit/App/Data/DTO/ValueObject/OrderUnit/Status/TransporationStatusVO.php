<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\Status;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

final readonly class TransporationStatusVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $order_unit_id,
        public string $enum_transporatrion_status_id,

    ) {}

    public static function make(

        string $order_unit_id,
        string $enum_transporatrion_status_id,

    ) : self {

        return new self(
            order_unit_id: $order_unit_id,
            enum_transporatrion_status_id: $enum_transporatrion_status_id,
        );

    }

    public function toArray() : array
    {
        return [
            "order_unit_id" => $this->order_unit_id,
            "enum_transporatrion_status_id" => $this->enum_transporatrion_status_id,
        ];
    }


}
