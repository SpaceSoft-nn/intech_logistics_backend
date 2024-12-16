<?php

namespace App\Modules\OfferContractor\Domain\Actions;

use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use Exception;

use function App\Helpers\Mylog;

class CreateAgreementOrderContractorAcceptAction
{
    public static function make(string $agreement_order_contractor_id) : AgreementOrderContractorAccept
    {
        return (new self())->run($agreement_order_contractor_id);
    }

    private function run(string $agreement_order_contractor_id) : AgreementOrderContractorAccept
    {

        try {

            $agreementOrderContractorAccept = AgreementOrderContractorAccept::create([
                "agreement_order_contractor_id" => $agreement_order_contractor_id,
                "order_bool" => false, //можно убрать
                "contractor_bool" => false, //можно убрать
            ]);

        } catch (\Throwable $th) {

            Mylog('Ошибка в CreateAgreementOrderContractorAcceptAction при создании записи: ' . $th);
            throw new Exception('Ошибка в CreateAgreementOrderContractorAcceptAction', 500);

        }

        return $agreementOrderContractorAccept;
    }
}
