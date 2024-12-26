<?php

namespace App\Http\Controllers\API\Tender\LotTenderController;

use App\Http\Controllers\Controller;
use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\Tender\Domain\Models\AgreementDocumentTender;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Requests\CreateLotTenderRequest;
use App\Modules\Tender\Domain\Resources\LotTenderCollection;
use App\Modules\Tender\Domain\Resources\LotTenderResource;
use App\Modules\Tender\Domain\Services\TenderService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class LotTenderController extends Controller
{

    public function index() {

        $lotTenders = LotTender::all();

        return response()->json(array_success(LotTenderCollection::make($lotTenders), 'Return all lot tender.'), 200);
    }

    public function show(
        LotTender $lotTender,
    ) {

        return response()->json(array_success(LotTenderResource::make($lotTender), 'Return lot tender.'), 200);
    }

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

    public function createOrderByTender(

    ) {

    }
}
