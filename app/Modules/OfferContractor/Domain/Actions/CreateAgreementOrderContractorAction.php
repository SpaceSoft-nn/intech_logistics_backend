<?php

namespace App\Modules\OfferContractor\Domain\Actions;

use App\Modules\OfferContractor\App\Data\ValueObject\AgreementOrderContractorVO;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use Exception;

use function App\Helpers\Mylog;

class CreateAgreementOrderContractorAction
{
    public static function make(AgreementOrderContractorVO $vo) : AgreementOrderContractor
    {
        return (new self())->run($vo);
    }

    private function run(AgreementOrderContractorVO $vo) : AgreementOrderContractor
    {

        try {

            $agreementOrderContractor = AgreementOrderContractor::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            Mylog('Ошибка в CreateAgreementOrderContractorAction при создании записи: ' . $th);
            throw new Exception('Ошибка в CreateAgreementOrderContractorAction', 500);

        }

        return $agreementOrderContractor;
    }
}
