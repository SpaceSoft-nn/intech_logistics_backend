<?php

namespace App\Modules\Transfer\App\Data\DTO\Transfer;


class TransferDTO
{


    public function __construct(

        public readonly string $transport_id,
        public ?string $description,

    ) {}

    public static function make(

        string $transport_id,
        ?string $description = null,

    ) : self {
        return new self(
            transport_id: $transport_id,
            description: $description,
        );
    }


}
