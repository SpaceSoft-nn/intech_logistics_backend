<?php

namespace App\Http\Controllers\API\OfferContractor;

use App\Http\Controllers\Controller;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorCreateRequest;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorCollection;
use App\Modules\OfferContractor\Domain\Resources\OfferContractorResource;
use App\Modules\OfferContractor\Domain\Services\OfferContractorService;
use Illuminate\Http\Request;

use function App\Helpers\array_success;

class OfferContractorController extends Controller
{

    public function index()
    {

        /**
        * @var OfferContractor[]
        */
        $offerContractors = OfferContractor::get();

        return response()->json(array_success(OfferContractorCollection::make($offerContractors), 'Return create offer contractor.'), 201);
    }

    public function create(
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
}
