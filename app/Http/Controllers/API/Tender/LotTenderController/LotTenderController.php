<?php

namespace App\Http\Controllers\API\Tender\LotTenderController;

use App\Http\Controllers\Controller;
use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\Tender\Domain\Requests\CreateLotTenderRequest;
use App\Modules\Tender\Domain\Services\DocumentFileService;
use App\Modules\Tender\Domain\Services\TenderService;
use Illuminate\Http\UploadedFile;

class LotTenderController extends Controller
{
    public function store(
        CreateLotTenderRequest $request,
        TenderService $service,
    ) {

        /** @var LotTenderVO */
        $lorTenderVO = $request->createLotTenderVO();

        /** @var UploadedFile */
        $agreementDocumentTenderFile = $request->getArrayAgreementDocumentTender();

        /** @var ?UploadedFile[] */
        $arrayApplicationDocumentTenderFiles = $request->getArrayApplicationDocumentTender();

        /** @var ?array */
        $arraySpecificalDatePeriod = $request->getArraySpecificalDatePeriod();

        /** @var CreateLotTenderServiceDTO */
        $createLotTenderServiceDTO = CreateLotTenderServiceDTO::make(
            lotTenderVO: $lorTenderVO,
            agreementDocumentTenderFile: $agreementDocumentTenderFile,
            arrayApplicationDocumentTenderFiles: $arrayApplicationDocumentTenderFiles,
            arraySpecificalDatePeriod: $arraySpecificalDatePeriod,
        );

        /**
         * @var LotTender
        */
        $model = $service->createLotTender($createLotTenderServiceDTO);

        dd($model);

    }
}
