<?php

namespace App\Http\Controllers\API\Tender;

use App\Http\Controllers\Controller;
use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\App\Data\ValueObject\AgreementDocumentTenderVO;
use App\Modules\Tender\App\Data\ValueObject\ApplicationDocumentTenderVO;
use App\Modules\Tender\App\Data\ValueObject\SpecificalDatePeriodVO;
use App\Modules\Tender\Domain\Requests\CreateLotTenderRequest;
use App\Modules\Tender\Domain\Services\TenderService;

class LotTenderController extends Controller
{
    public function store(
        CreateLotTenderRequest $request,
        TenderService $service,
    ) {
        /** @var  LotTenderVO */
        $lorTenderVO = $request->createLotTenderVO();

        /** @var  AgreementDocumentTenderVO */
        $agreementDocumentTenderVO = $request->createAgreementDocumentTenderVO();

        /** @var ?ApplicationDocumentTenderVO[] */
        $arrayApplicationDocumentTenderVO = $request->getArrayApplicationDocumentTender();



        /** @var  ?SpecificalDatePeriodVO[] */
        $arraySpecificalDatePeriodVO = ApplicationDocumentTenderVO::make(

        ):

        /** @var CreateLotTenderServiceDTO */
        $createLotTenderServiceDTO = CreateLotTenderServiceDTO::make(
            lotTenderVO:,
            $arraySpecificalDatePeriodVO:
            $arrayApplicationDocumentTenderVO:,
            $arraySpecificalDatePeriodVO:,
        );


    }
}
