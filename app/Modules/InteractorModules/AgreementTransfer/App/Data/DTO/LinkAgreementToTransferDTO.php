<?php

namespace App\Modules\InteractorModules\AgreementTransfer\App\Data\DTO;

use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\Transfer\Domain\Models\Transfer;

class LinkAgreementToTransferDTO
{
    public function __construct(

        public readonly AgreementOrder $agreementOrder,
        public readonly Transfer $transfer,
        public bool $order_main,

    ) { }

    public static function make(
        AgreementOrder $agreementOrder,
        Transfer $transfer,
        bool $order_main = false,

    ) : self {


        return new self(
            agreementOrder: $agreementOrder,
            transfer: $transfer,
            order_main: $order_main,
        );

    }

}
