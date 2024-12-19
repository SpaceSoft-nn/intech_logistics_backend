<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\StatusTransportationEvent;

use App\Modules\OrderUnit\App\Data\Enums\StatusTransportationEventOrderEnum;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

final readonly class StatusTransportationEventVO implements Arrayable
{
    public function __construct(

        public string $order_unit_id,
        public StatusTransportationEventOrderEnum $status,

    ) {}

    public static function make(

        string $order_unit_id,
        string $status,

    ) : self {

        return new self(
            order_unit_id: $order_unit_id,
            status: StatusTransportationEventOrderEnum::stringByCaseToObject($status),
        );

    }

    public function toArray() : array
    {
        return [
            'order_unit_id' => $this->order_unit_id,
            'status' => $this->status->value,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {
        return static::make(
            order_unit_id: Arr::get($data, 'order_unit_id'),
            status: Arr::get($data, 'status'),
        );
    }

}
