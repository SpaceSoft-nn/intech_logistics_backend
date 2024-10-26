<?php

namespace App\Modules\Transfer\Domain\Actions\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class TransferVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

            public readonly string $transport_id,
            public readonly string $description,

    ) {}

    public static function make(

        string $transport_id,
        string $description,

    ) : self {
        return new self(
            transport_id: $transport_id,
            description: $description,
        );
    }

    public function toArray() : array
    {
        return [
            "body_volume" => $this->body_volume,
            "description" => $this->description,
        ];
    }

}
