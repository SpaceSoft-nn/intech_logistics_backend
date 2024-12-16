<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OfferContractorCustomerCollection extends ResourceCollection
{
    public $collects = OfferContractorCustomerResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
