<?php

namespace App\Http\Controllers\API\Tender\LotTenderController;

use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Modules\Base\Enums\WeekEnum;
use function App\Helpers\array_error;
use function App\Helpers\array_success;

use Illuminate\Support\Facades\Storage;
use App\Modules\Tender\Domain\Models\LotTender;

use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Tender\Domain\Services\TenderService;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\Tender\Domain\Resources\LotTenderResource;
use App\Modules\Tender\App\Repositories\TenderRepositories;
use App\Modules\Tender\App\Data\DTO\AddInfoOrderByTenderDTO;
use App\Modules\Tender\Domain\Models\AgreementDocumentTender;
use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Requests\CreateLotTenderRequest;
use App\Modules\Tender\Domain\Requests\AddInfoOrderByTenderRequest;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitResource;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitCollection;
use App\Modules\Tender\Domain\Resources\Response\AgreementTenderResource;
use App\Modules\Tender\Domain\Resources\Response\Wrapp\WrappLotTenderCollection;
use App\Modules\Tender\Domain\Resources\Filter\ContractorComporeLotTenderResource;
use App\Modules\Tender\Domain\Resources\Filter\ContractorComporeLotTenderCollection;

class LotTenderController extends Controller
{

    public function index(
        GetTypeCabinetByOrganization $action,
        TenderRepositories $rep
    ) {

        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];


        if($array['status']) {


            return response()->json(array_success(WrappLotTenderCollection::make($organization->tenders), 'Return all tenders by organization Customer .'), 200);

        } else {

            //получаем все ордеры, и указываем на какие откликнулся перевозчик
            $tenders = $rep->getTendersFilterByContractor($organization->id);

            #TODO Костыль который попросил сделать фротенд - здесь нужно пересмотреть, очень много запросов будет в бд.
            return response()->json(array_success(ContractorComporeLotTenderCollection::make($tenders), 'Возращены все тендеры, с фильтрацией при выборе перевозчикам тендера.'), 200);
        }

    }

    public function show(
        LotTender $lotTender,
        GetTypeCabinetByOrganization $action,
        TenderRepositories $rep,
    ) {

         /** @var array */
       $array = $action->isCustomer();

       /** @var Organization */
       $organization = $array['organization'];

       if($array['status']) {

           return response()->json(array_success(LotTenderResource::make($lotTender), 'Return Tender by organization Customer .'), 200);

       } else {

           //получаем все ордеры, и указываем на какие откликнулся перевозчик
           $order = $rep->getTenderFilterByContractor($organization->id, $lotTender->id);

           #TODO Костыль который попросил сделать фротенд - здесь нужно пересмотреть, очень много запросов будет в бд.
           return response()->json(array_success(ContractorComporeLotTenderResource::make($order), 'Возращены все тендеры, с фильтрацией при выборе перевозчикам тендера.'), 200);
       }
    }

    public function store(
        CreateLotTenderRequest $request,
        TenderService $service,
    ) {

        /** @var LotTenderVO value object лота тендера*/
        $lorTenderVO = $request->createLotTenderVO();

        /** @var UploadedFile главный документ тендера */
        $agreementDocumentTenderFile = $request->getArrayAgreementDocumentTender();

        /** @var ?UploadedFile[] дополнительные приложения - файлы */
        $arrayApplicationDocumentTenderFiles = $request->getArrayApplicationDocumentTender();

        /** @var ?array получаем массив дат выполнения тендера */
        $arraySpecificalDatePeriod = $request->getArraySpecificalDatePeriod();

        /** @var ?WeekEnum[] получаем массив дней недель */
        $arrayWeekPeriod = $request->getArrayWeekPeriod();


        /** @var CreateLotTenderServiceDTO */
        $createLotTenderServiceDTO = CreateLotTenderServiceDTO::make(
            lotTenderVO: $lorTenderVO,
            agreementDocumentTenderFile: $agreementDocumentTenderFile,
            arrayApplicationDocumentTenderFiles: $arrayApplicationDocumentTenderFiles,
            arraySpecificalDatePeriod: $arraySpecificalDatePeriod,
            arrayWeekPeriod:  $arrayWeekPeriod,
        );

        /**
         * @var LotTender
        */
        $model = $service->createLotTender($createLotTenderServiceDTO);

        return $model ?
            response()->json(array_success(LotTenderResource::make($model), 'Create lot tender.'), 201)
        :
            response()->json(array_error(null, 'Faild create lot tender.'), 400);
    }

    public function agreementDocumentFile(
        AgreementDocumentTender $agreementDocumentTender
    ) {

        if (Storage::disk($agreementDocumentTender->disk)->exists($agreementDocumentTender->path)) {
            return Storage::disk($agreementDocumentTender->disk)->download($agreementDocumentTender->path);
        } else {
            abort(404, 'Файл не найден.');
        }
    }

    //получить все заказы по тендеру
    public function getAllOrderFromTender(LotTender $lotTender)
    {
        return response()->json(array_success(OrderUnitCollection::make($lotTender->order_unit), 'Return all order unit by lot tender.'), 200);
    }

    public function addInfoOrderByTender(
        LotTender $lotTender,
        OrderUnit $orderUnit,
        AddInfoOrderByTenderRequest $request,
        TenderService $service,
    ) {

        #TODO LotTender $lotTender, - проверять что lot относится к пользователю + order

        /**
        * @var ?CargoGoodVO[]
        */
        $cargoGoodVO = $request->createCargoGoodVO();

        /**
        * @var OrderUnitAddressDTO
        */
        $orderUnitAddressDTO = $request->createOrderUnitAddressDTO();


        $model = $service->addInfoOrderByTender(
            AddInfoOrderByTenderDTO::make(
                orderUnit: $orderUnit,
                orderUnitAddressDTO: $orderUnitAddressDTO,
                cargoGoodVO: $cargoGoodVO,
            )
        );

        return response()->json(array_success(OrderUnitResource::make($model), 'Successful update order unit By tender.'), 200);
    }


    //Вернуть принятый отклик на тендер
    public function getAgreementTenderByTender(LotTender $lotTender)
    {

        $model = AgreementTender::where('lot_tender_id',  $lotTender->id)->first();

        return is_null($model)
            ? response()->json(array_success(null, 'Запись выбранного отклика успешна возвращена.'), 200)
            : response()->json(array_success(AgreementTenderResource::make($model), 'Запись выбранного отклика успешна возвращена.'), 200);
    }


}
