<?php

namespace App\Modules\Transfer\App\Data\DTO\Transfer;

use App\Modules\Transfer\Domain\Models\Transfer;

/**
 * @property string $main_order_id
 * @property string[] $agreementOrder_id
 * @property TransferDTO $transferDTO
 */
class CreateTransferServiceDTO
{
    public function __construct(
        public readonly string $main_order_id,
        public ?array $agreementOrder_id,
        public readonly TransferDTO $transferDTO,
    ) {}

    public static function make(
        string $main_order_id,
        ?array $agreementOrder_id,
        TransferDTO $transferDTO,
    ) : self {

        return new self(
            main_order_id: $main_order_id,
            agreementOrder_id: $agreementOrder_id,
            transferDTO: $transferDTO,
        );

    }

}
