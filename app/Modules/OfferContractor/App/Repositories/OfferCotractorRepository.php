<?php

namespace App\Modules\OfferContractor\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Actions\Filter\OfferContractorAndCustomerFilter;
use App\Modules\OfferContractor\Domain\Actions\Filter\OfferContractorsAndCustomerFilter;
use App\Modules\OfferContractor\Domain\Actions\OfferContractor\OfferContractorCreateAction;
use App\Modules\OfferContractor\Domain\Models\OfferContractor as Model;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use Illuminate\Database\Eloquent\Collection;

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


    public function getOfferContractorsFilterByContractor(string $organization_id) : Collection
    {
        return OfferContractorsAndCustomerFilter::execute($organization_id);
    }

    public function getOfferContractorFilterByContractor(string $organization_id,string $offer_contractor_uuid) : ?OfferContractor
    {
        return OfferContractorAndCustomerFilter::execute($organization_id, $offer_contractor_uuid);
    }

}
