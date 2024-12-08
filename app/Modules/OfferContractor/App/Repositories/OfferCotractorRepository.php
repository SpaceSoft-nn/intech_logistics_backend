<?php

namespace App\Modules\OfferContractor\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Actions\OfferContractor\OfferContractorCreateAction;
use App\Modules\OfferContractor\Domain\Models\OfferContractor as Model;


class OfferCotractorRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function create(OfferContractorVO $vo) : Model
    {
        return OfferContractorCreateAction::make($vo);
    }


}
