<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContractorComporeOrderUnitCollection extends ResourceCollection
{

    public $collects = ContractorComporeOrderUnitResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

}
