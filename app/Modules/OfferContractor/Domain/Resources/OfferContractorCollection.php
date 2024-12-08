<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OfferContractorCollection extends ResourceCollection
{
    public $collects = OfferContractorResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
