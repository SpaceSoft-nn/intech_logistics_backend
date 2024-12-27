<?php

namespace App\Modules\Tender\Domain\Interactor;

use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderVO;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use DB;

// Бизнес логика на согласование Тендера с двух сторон - здесь же создаются заказы (pre-order)
final class AgreementTenderAcceptInteractor
{

    public function execute(AgreementTenderAccept $agreementTenderAccept) : AgreementTenderAccept
    {
        return $this->run($agreementTenderAccept);
    }


    public function run(AgreementTenderAccept $agreementTenderAccept) : AgreementTenderAccept
    {

        #TODO Временная логика - устанавливаем bool с двух сторон
        $agreementTenderAccept->tender_creater_bool = true;
        $agreementTenderAccept->contractor_bool = true;
        #TODO - Создание заказов

        $agreementTenderAccept->save();

        // /** @var AgreementTender  */
        // $model = DB::transaction(function () use ($agreementTenderAccept) {

        // });

        return $$agreementTenderAccept;

    }




}
