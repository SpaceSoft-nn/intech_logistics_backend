<?php

namespace App\Http\Controllers\API\OfferContractor;

use App\Http\Controllers\Controller;
use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorAddCustomerRequest;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorCreateRequest;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorCollection;
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

        dd($offerContractor, $organization);

        /**
        * @var InvoiceOrderCustomerVO
        *
        */
        $invoiceOrderCustomerVO = $request->createInvoiceOrderCustomerVO();


    }
}
