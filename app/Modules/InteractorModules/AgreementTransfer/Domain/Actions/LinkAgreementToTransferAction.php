<?php

namespace App\Modules\InteractorModules\AgreementTransfer\Domain\Actions;

use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\Transfer\Domain\Models\Transfer;

class LinkAgreementToTransferAction
{
    public static function run(AgreementOrder $agreementOrder, Transfer $transfer) : bool
    {
        try {

            //Сохраняем связь от AgreementOrder к Transfer
            $agreementOrder->transfers()->syncWithoutDetaching([$transfer->id]);

            return true;

        } catch (\Throwable $th) {

            return false;

        }

    }
}
