<?php

namespace App\Http\Controllers\API\Tender\ResponseTenderController;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Requests\CreateResponseTenderRequest;
use App\Modules\Tender\Domain\Services\AgreementTenderService;

class ResponseTenderController extends Controller
{
    /** Добавление контрактора/перевозчика к тендеру (отклик) */
    public function addСontractorForTender(
        LotTender $lotTender,
        Organization $organization,
        CreateResponseTenderRequest $request,
        AgreementTenderService $service,
    ) {
        /** @var CreateResponseTenderDTO создаём DTO для сервиса, указываем дополнительные поля пересоздавая экземпляр */
        $createResponseTenderDTO = $request->CreateResponseTenderDTO()
            ->setOrganizationId($organization->id)->setLotTenderId($lotTender->id);

        $model =  $service->respondToTender()
    }
}
