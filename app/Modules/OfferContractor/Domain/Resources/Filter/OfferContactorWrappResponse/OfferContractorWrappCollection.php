<?php

namespace App\Modules\OfferContractor\Domain\Resources\Filter\OfferContactorWrappResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OfferContractorWrappCollection extends ResourceCollection
{
    public $collects = OfferContractorWrappResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

}
