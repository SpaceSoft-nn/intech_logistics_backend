<?php

namespace App\Http\Controllers\API\Tender\ResponseTenderController;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Requests\CreateLotTenderRequest;

class ResponseTenderController extends Controller
{
    /** Добавление контрактора/перевозчика к тендеру (отклик) */
    public function addСontractorForTender(
        LotTender $lotTender,
        Organization $organization,
        CreateLotTenderRequest $request,
    ) {
        /** @var CreateResponseTenderDTO */
        $createResponseTenderDTO = $request->CreateResponseTenderDTO()->setOrganizationId($organization->id);

        dd($createResponseTenderDTO);
    }
}
