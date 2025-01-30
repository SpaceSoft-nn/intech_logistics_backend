<?php

namespace App\Modules\Tender\Domain\Resources\Filter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContractorComporeLotTenderCollection extends ResourceCollection
{

    public $collects = ContractorComporeLotTenderResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

}
