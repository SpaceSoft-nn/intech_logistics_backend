<?php

namespace App\Modules\Tender\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecificaDatePeriodCollection extends ResourceCollection
{

    public $collects = SpecificaDatePeriodResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
