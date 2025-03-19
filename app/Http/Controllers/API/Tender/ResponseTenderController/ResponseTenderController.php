<?php

namespace App\Http\Controllers\API\Tender\ResponseTenderController;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Domain\Services\AuthService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Services\AgreementTenderService;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;
use App\Modules\Tender\Domain\Requests\CreateResponseTenderRequest;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use App\Modules\Tender\Domain\Requests\CreateAgreementTenderRequest;
use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderVO;
use App\Modules\Tender\Domain\Resources\Response\AgreementTenderResource;
use App\Modules\Tender\Domain\Resources\Response\LotTenderResponseResource;

use App\Modules\Tender\Domain\Resources\Response\LotTenderResponseCollection;
use App\Modules\Tender\Domain\Resources\Response\AgreementTenderAcceptResource;
use App\Modules\User\Domain\Models\User;

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
        $createResponseTenderDTO = $request->createResponseTenderDTO()
            ->setOrganizationId($organization->id)->setLotTenderId($lotTender->id);

        /** @var LotTenderResponse */
        $model = $service->respondToTender($createResponseTenderDTO);

        return $model ?
            response()->json(array_success(LotTenderResponseResource::make($model), 'Create lot tender response.'), 201)
        :
            response()->json(array_error(null, 'Faild create lot tender response.'), 400);
    }

    /** Создатель тендера выбирает подрядчика на выполнения тендера */
    public function agreementTender(
        LotTenderResponse $lotTenderResponse,
        CreateAgreementTenderRequest $request,
        AgreementTenderService $service,
    ) {

        $validated = $request->validated();


        $agreementTenderVO = AgreementTenderVO::make(
            lot_tender_response_id: $lotTenderResponse->id,
            organization_contractor_id: $validated['organization_contractor_id'] ?? null,
            lot_tender_id: $lotTenderResponse->lot_tender_id,
        );

        /** @var AgreementTender */
        $model = $service->agreementTender($agreementTenderVO);

        return $model ?
            response()->json(array_success(AgreementTenderResource::make($model), 'Create lot tender response.'), 201)
        :
            response()->json(array_error(null, 'Faild create lot tender response.'), 400);

    }

    //Вернуть всех исполнителей откликнувшиеся на Тендер
    public function getСontractorForTender(LotTender $lotTender)
    {
        $model = LotTenderResponse::query()->where('lot_tender_id', $lotTender->id)->get();

        return response()->json(array_success(LotTenderResponseCollection::make($model), 'Return all lot tender Response.'), 200);
    }

    //Двух-соторонне соглашения
    public function agreementTenderAccept(

        AgreementTenderAccept $agreementTenderAccept,
        AgreementTenderService $agreementTenderService,
        AuthService $auth,

    ) {

        /**
        * @var User
        */
        $user = isAuthorized($auth);

        /** @var AgreementTenderAccept */
        $model = $agreementTenderService->agreementTenderAccept($user, $agreementTenderAccept);

        return $model ?
        response()->json(array_success(AgreementTenderAcceptResource::make($model), 'Successfully agreement tender accept.'), 200)
        :
        response()->json(array_error(null, 'Error agreement tender accept.'), 400);
    }

}

