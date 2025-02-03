<?php

namespace App\Modules\OfferContractor\Domain\Resources\Filter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerComporeOfferContractorCollection extends ResourceCollection
{
    public $collects = CustomerComporeOfferContractorResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
