<?php

namespace App\Modules\Transfer\Domain\Interactor\Transfer;

use App\Modules\OrderUnit\Domain\Models\AgreementOrder;

/**
 * Объединение создание логики transfer с остальными таблицами/моделями
 */
class TransferCreateInterctor
{
    public function run()
    {

    }

    private function linkAgreementTransfer(array $agreementOrder_id, string $order_main)
    {
        $model = AgreementOrder::find($agreementOrder_id);
    }
}
