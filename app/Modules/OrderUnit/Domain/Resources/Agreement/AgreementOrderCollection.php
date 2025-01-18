<?php

namespace App\Modules\OrderUnit\Domain\Resources\Agreement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AgreementOrderCollection extends ResourceCollection
{

    public $collects = AgreementOrderResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
