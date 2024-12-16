<?php

namespace App\Http\Controllers\API\OfferContractor;

use App\Http\Controllers\Controller;
use App\Modules\OfferContractor\App\Data\DTO\OfferContractorAgreementOfferDTO;
use App\Modules\OfferContractor\App\Data\DTO\OfferCotractorAddCustomerDTO;
use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorAddCustomerRequest;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorAgreementOfferRequest;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorCreateRequest;
use App\Modules\OfferContractor\Domain\Resources\AgreementOrderContractorResource;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorCollection;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorCustomerCollection;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorCustomerResource;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorResource;
use App\Modules\OfferContractor\Domain\Services\OfferContractorService;
use App\Modules\Organization\Domain\Models\Organization;

use function App\Helpers\array_success;

class OfferContractorController extends Controller
{

    public function index()
    {
        /**
        * @var OfferContractor[]
        */
        $offerContractors = OfferContractor::get();

        return response()->json(array_success(OfferContractorCollection::make($offerContractors), 'Return create offer contractors.'), 200);
    }

    public function store(
        OfferContractorCreateRequest $request,
        OfferContractorService $serv,
    ) {

        /**
        * @var OfferContractorVO
        */
        $offerContractorVO = $request->createOfferContractorVO();

        $offerContractor = $serv->createOfferContractor($offerContractorVO);

        return response()->json(array_success(OfferContractorResource::make($offerContractor), 'Return create offer contractor.'), 201);

    }

    /**
     * Добавление заказчика к предложению перевозчика (отклик)
     * @param Organization $organization организация Заказчика (кто откликнулся  на предложения перевозчика)
     */
    public function addCustomer(
        OfferContractor $offerContractor,
        Organization $organization,
        OfferContractorAddCustomerRequest $request,
        OfferContractorService $offerContractorService,
    ) {
        /**
        * @var InvoiceOrderCustomerVO
        *
        */
        $invoiceOrderCustomerVO = $request->createInvoiceOrderCustomerVO();


        /**
         * @var OfferContractorCustomer
        */
        $offerContractorCustomer = $offerContractorService->responseOfferContractor(
            OfferCotractorAddCustomerDTO::make(
                invoiceOrderCustomerVO: $invoiceOrderCustomerVO,
                organization: $organization,
                offerContractor: $offerContractor,
            ),
        );

        return response()->json(array_success(OfferContractorCustomerResource::make($offerContractorCustomer), 'Успешно добавлен отклик на предложения перевозчика.'), 201);

    }

    public function getAddCustomer(OfferContractor $offerContractor)
    {
        $offerContractorCustomers = OfferContractorCustomer::where('offer_contractor_id', $offerContractor->id)->get();

        return response()->json(array_success(OfferContractorCustomerCollection::make($offerContractorCustomers), 'Возврат всех откликов по предложению.'), 200);
    }

    public function agreementOffer(
        OfferContractor $offerContractor,
        OfferContractorAgreementOfferRequest $request,
        OfferContractorService $offerContractorService,
    ) {


        $validated = $request->validated();

        /**
        * @var AgreementOrderContractor
        */
        $agreementOrderContractor = $offerContractorService->agreementOffer(
            OfferContractorAgreementOfferDTO::make(
                offer_contractor_customer_id: $validated['offer_contractor_customer_id'],
                offerContractor: $offerContractor,
            )
        );

        return response()->json(array_success(AgreementOrderContractorResource::make($agreementOrderContractor), 'Организация заказчика, успешна была выбрана на исполнения предложения.'), 200);
    }
}
