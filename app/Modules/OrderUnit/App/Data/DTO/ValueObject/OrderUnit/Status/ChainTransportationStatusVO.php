<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\Status;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

final readonly class ChainTransportationStatusVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $order_unit_id,
        public string $from_status_id,
        public string $to_status_id,
        public bool $active_status,
        public ?string $comment,

    ) {}

    public static function make(

        string $order_unit_id,
        string $from_status_id,
        string $to_status_id,
        bool $active_status,
        ?string $comment = null,

    ) : self {

        return new self(
            order_unit_id: $order_unit_id,
            from_status_id: $from_status_id,
            to_status_id: $to_status_id,
            active_status: $active_status,
            comment: $comment,
        );

    }

    public function toArray() : array
    {
        return [
            "order_unit_id" => $this->order_unit_id,
            "from_status_id" => $this->from_status_id,
            "to_status_id" => $this->to_status_id,
            "active_status" => $this->active_status,
            "comment" => $this->comment,
        ];
    }

    // public static function fromArrayToObject(array $data): self
    // {
    //     return static::make(
    //         order_unit_id: Arr::get($data, 'order_unit_id'),
    //     );
    // }
}
