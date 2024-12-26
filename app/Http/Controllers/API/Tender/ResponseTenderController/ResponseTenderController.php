<?php

namespace App\Http\Controllers\API\Tender\ResponseTenderController;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderVO;
use App\Modules\Tender\App\Data\ValueObject\Response\LotTenderResponse;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse as ResponseLotTenderResponse;
use App\Modules\Tender\Domain\Requests\CreateAgreementTenderRequest;
use App\Modules\Tender\Domain\Requests\CreateResponseTenderRequest;
use App\Modules\Tender\Domain\Resources\Response\AgreementTenderResource;
use App\Modules\Tender\Domain\Resources\Response\LotTenderResponseResource;
use App\Modules\Tender\Domain\Services\AgreementTenderService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

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

        /** @var LotTenderResponse */
        $model =  $service->respondToTender($createResponseTenderDTO);

        return $model ?
            response()->json(array_success(LotTenderResponseResource::make($model), 'Create lot tender response.'), 201)
        :
            response()->json(array_error(null, 'Faild create lot tender response.'), 400);
    }

    /** Создатель тендера выбирает подрядчика на выполнения тендера */
    public function agreementTender(
        ResponseLotTenderResponse $lotTenderResponse,
        CreateAgreementTenderRequest $request,
        AgreementTenderService $service,
    ) {

        $validated = $request->validated();


        $agreementTenderVO = AgreementTenderVO::make(
            lot_tender_response_id: $lotTenderResponse->id,
            organization_tender_create_id: $validated['organization_tender_create_id'] ?? null,
            lot_tender_id: $lotTenderResponse->lot_tender_id,
        );

        /** @var AgreementTender */
        $model = $service->agreementTender($agreementTenderVO);

        return $model ?
            response()->json(array_success(AgreementTenderResource::make($model), 'Create lot tender response.'), 201)
        :
            response()->json(array_error(null, 'Faild create lot tender response.'), 400);


    }
}
