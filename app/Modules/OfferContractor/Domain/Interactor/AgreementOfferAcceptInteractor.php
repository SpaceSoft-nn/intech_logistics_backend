<?php

namespace App\Modules\OfferContractor\Domain\Interactor;


use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use DB;


class AgreementOfferAcceptInteractor
{

    public static function execute(AgreementOrderContractorAccept $agreementOrderAccept) : AgreementOrderContractorAccept
    {
        return (new self())->run($agreementOrderAccept);
    }


    private function run(AgreementOrderContractorAccept $agreementOrderAccept) : AgreementOrderContractorAccept
    {

        /**
        * @var AgreementOrderContractorAccept
        */
        $agreementOrderContractor = DB::transaction(function () use ($agreementOrderAccept) {

            #TODO Оставить логику до работы с ролями и доступами
            $agreementOrderAccept->order_bool = true;
            $agreementOrderAccept->contractor_bool = true;

            $agreementOrderAccept->save();

            return $agreementOrderAccept;

        });

        return $agreementOrderContractor;
    }

}
