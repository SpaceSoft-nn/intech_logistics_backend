<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use Illuminate\Contracts\Support\Arrayable;

final readonly class OrderUnitStatusVO implements Arrayable
{

    /**
     * @param OrderUnitVO $orderUnitVO
     * @param OrderUnitAddressDTO $orderUnitAddressDTO
     * @param CargoGoodVO[] $cargoGoodVO
    */
    public function __construct(

        public string $order_unit_id,
        public ?StatusOrderUnitEnum $status,

    ) {}

    public static function make(

        string $order_unit_id,
        string $status = "draft",

    ) : self {

        return new self(
            order_unit_id: $order_unit_id,
            status: StatusOrderUnitEnum::stringByCaseToObject($status),
        );

    }

    public function toArray() : array
    {
        return [
            'order_unit_id' => $this->order_unit_id,
            'status' => $this->status?->value,
        ];
    }

}
