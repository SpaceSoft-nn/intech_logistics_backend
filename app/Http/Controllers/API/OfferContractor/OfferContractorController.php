<?php

namespace App\Http\Controllers\API\OfferContractor;

use App\Http\Controllers\Controller;
use function App\Helpers\isAuthorized;

use function App\Helpers\array_success;
use App\Modules\User\Domain\Models\User;

use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use App\Modules\OfferContractor\Domain\Services\OfferContractorService;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorResource;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OfferContractor\App\Data\DTO\OfferCotractorAddCustomerDTO;
use App\Modules\OfferContractor\App\Repositories\OfferCotractorRepository;
use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorCreateRequest;
use App\Modules\OfferContractor\Domain\Requests\UpdateOfferContractorRequest;
use App\Modules\OfferContractor\App\Data\DTO\OfferContractorAgreementOfferDTO;
use App\Modules\OfferContractor\App\Data\DTO\OfferContractorAgreementOrderDTO;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorCustomerResource;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorAddCustomerRequest;
use App\Modules\OfferContractor\Domain\Resources\AgreementOrderContractorResource;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorCustomerCollection;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorAgreementOfferRequest;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorAgreementOrderRequest;
use App\Modules\OfferContractor\Domain\Resources\AgreementOrderContractorAcceptResource;

use App\Modules\OfferContractor\Domain\Resources\Filter\CustomerComporeOfferContractorResource;
use App\Modules\OfferContractor\Domain\Resources\Filter\CustomerComporeOfferContractorCollection;
use App\Modules\OfferContractor\Domain\Resources\Filter\OfferContactorWrappResponse\OfferContractorWrappResource;
use App\Modules\OfferContractor\Domain\Resources\Filter\OfferContactorWrappResponse\OfferContractorWrappCollection;

class OfferContractorController extends Controller
{

    public function index(
        GetTypeCabinetByOrganization $action,
        OfferCotractorRepository $rep,
    ) {

        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];

        if($array['status']) {

            //Возвращаем предложения перевозчика которые связаны только с ним

            //получаем все ордеры, и указываем на какие предложения откликнулся заказчик
            $offers = $rep->getOfferContractorsFilterByContractor($organization->id);

            #TODO Костыль который попросил сделать фротенд - здесь нужно пересмотреть, очень много запросов будет в бд.
            return response()->json(array_success(CustomerComporeOfferContractorCollection::make($offers), 'Возращены все офферы "предложения" перевозчика, с фильтрацией при указани отклика заказчика на оффер.'), 200);

        } else {

            return response()->json(array_success(OfferContractorWrappCollection::make($organization->offer_contractors), 'Return offer сontractor by organization carrier.'), 200);
        }

    }

    public function show(
        OfferContractor $offerContractor,
        GetTypeCabinetByOrganization $action,
        OfferCotractorRepository $rep,
    ) {

        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];

        if($array['status']) {

            //Возвращаем предложения перевозчика которыесвязаны только с ним

            //получаем все ордеры, и указываем на какие предложения откликнулся заказчик
            /** @var OfferContractor */
            $offers = $rep->getOfferContractorFilterByContractor($organization->id, $offerContractor->id);

            #TODO Костыль который попросил сделать фротенд - здесь нужно пересмотреть, очень много запросов будет в бд.
            return response()->json(array_success(CustomerComporeOfferContractorResource::make($offers), 'Возвращен оффер предложение с фильтрацией по отклику от заказчика'), 200);

        } else {

            return response()->json(array_success(OfferContractorWrappResource::make($offerContractor), 'Return offer сontractor by organization carrier.'), 200);
        }
    }

    public function store(
        OfferContractorCreateRequest $request,
        OfferContractorService $serv,
    ) {

        /**
        * @var OfferContractorVO
        */
        $offerContractorVO = $request->createOfferContractorVO();

        /** @var OfferContractor */
        $offerContractor = $serv->createOfferContractor($offerContractorVO);

        return response()->json(array_success(OfferContractorResource::make($offerContractor), 'Return create offer contractor.'), 201);

    }

    public function update(
        OfferContractor $offerContractor,
        UpdateOfferContractorRequest $request,
        OfferContractorService $serv,
    ) {

        /**
        * @var OfferContractorVO
        */
        $offerContractorVO = $request->fromArrayToObjectForModel($offerContractor);

        /**
        * @var OfferContractor
        */
        $model = $serv->updateOfferContractor($offerContractorVO, $offerContractor);

        return response()->json(array_success(OfferContractorResource::make($model), 'Update Offer Contractor Successfully.'), 200);
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
        */
        $invoiceOrderCustomerVO = $request->createInvoiceOrderCustomerVO();


        /** @var CargoGoodVO[] */
        $cargoGoodVO_array = $request->createCargoGoodVO();

        /**
         * @var OfferContractorCustomer
        */
        $offerContractorCustomer = $offerContractorService->responseOfferContractor(
            OfferCotractorAddCustomerDTO::make(
                invoiceOrderCustomerVO: $invoiceOrderCustomerVO,
                organization: $organization,
                offerContractor: $offerContractor,
                cargoGoodVO_array: $cargoGoodVO_array,
            ),
        );


        return response()->json(array_success(OfferContractorCustomerResource::make($offerContractorCustomer), 'Успешно добавлен отклик на предложения перевозчика.'), 201);

    }

    public function getAddCustomer(OfferContractor $offerContractor)
    {

        /** @var OfferContractorCustomer */
        $offerContractorCustomers = OfferContractorCustomer::where('offer_contractor_id', $offerContractor->id)
            ->with('offer_contractor', 'invoice_order_customer', 'organization')->get();


        return response()->json(array_success(OfferContractorCustomerCollection::make($offerContractorCustomers), 'Возврат всех откликов по предложению.'), 200);
    }

    //перевозчик выбирает (организацию - заказчика) на исполнение заявки предложения
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

    /**
     * Вернуть запись когда перевозчик выбрал организацию - заказчика "исполнителя"
     * @param OfferContractor $offerContractor
     *
     */
    public function getAgreementOffer(OfferContractor $offerContractor)
    {

        return $offerContractor->agreement_order_contractor
            ? response()->json(array_success(AgreementOrderContractorResource::make($offerContractor->agreement_order_contractor ), 'Возвратили запись о назначенном исполнителе в лице организации заказчика, по предложению перевозчика.'), 200)
            : response()->json(array_success(null, 'Возвратили запись о назначенном исполнителе в лице организации заказчика, по предложению перевозчика.'), 200);
    }

    /**
     * УКтверждения двух стороннего договора
     * @param AgreementOrderContractorAccept $agreementOrderContractorAccept
     *
     */
    public function agreementOfferAccept(
        AgreementOrderContractorAccept $agreementOrderContractorAccept,
        OfferContractorService $offerContractorService,
        AuthService $auth,
    ) {

        /**
        * @var User
        */
        $user = isAuthorized($auth);

        $result = $offerContractorService->agreementOfferAccept($user, $agreementOrderContractorAccept);

        return $result->status
            ? response()->json(array_success(AgreementOrderContractorAcceptResource::make($result->data) ?? null, $result->message), 200)
                : response()->json(array_success(null, $result->message), 403);

    }

    public function agreementOfferOrder(
        AgreementOrderContractorAccept $agreementOrderContractorAccept,
        OfferContractorAgreementOrderRequest $request,
        OfferContractorService $offerContractorService,
    ) {

        { //формируем данные для DTO и создание Заказа
            /**
            * @var OrderUnitVO
            */
            $orderUnitVO = $request->createOrderUnitVO();

            /**
            * @var ?CargoGoodVO[]
            */
            $cargoGoodVO = $request->createCargoGoodVO();

            /**
            * @var OrderUnitAddressDTO
            */
            $orderUnitAddressDTO = $request->createOrderUnitAddressDTO();
        }


        /**
         * @var OrderUnitCreateDTO
         */
        $orderUnitCreateDTO = OrderUnitCreateDTO::make(
            orderUnitVO: $orderUnitVO,
            orderUnitAddressDTO: $orderUnitAddressDTO,
            cargoGoodVO : $cargoGoodVO,
        );

        $status = $offerContractorService->agreementOfferOrder(
            OfferContractorAgreementOrderDTO::make(
                orderUnitCreateDTO: $orderUnitCreateDTO,
                agreementOrderContractorAccept: $agreementOrderContractorAccept,
            )
        );

        return $status ?
            response()->json(array_success(null, 'Заказ был успешно создан.'), 200)
            : response()->json(array_success(null, 'Ошибка создание заказа.'), 404);
    }
}
