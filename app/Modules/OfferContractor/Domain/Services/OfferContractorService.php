<?php

namespace App\Modules\OfferContractor\Domain\Services;

use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\App\Repositories\OfferCotractorRepository;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;

class OfferContractorService
{

    public function __construct(
        private OfferCotractorRepository $offerCotractorRep,
    ) { }


    public function createOfferContractor(OfferContractorVO $vo) : OfferContractor
    {
        return $this->offerCotractorRep->create($vo);
    }
}
