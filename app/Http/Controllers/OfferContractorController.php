<?php

namespace App\Http\Controllers;

use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Requests\OfferContractorCreateRequest;
use App\Modules\OfferContractor\Domain\Services\OfferContractorService;
use Illuminate\Http\Request;

class OfferContractorController extends Controller
{

    public function index(

    ) {
        dd(1);
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

        dd($offerContractor);
    }
}
