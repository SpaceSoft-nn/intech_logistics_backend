<?php

namespace App\Modules\Tender\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LotTenderCollection extends ResourceCollection
{

    public $collects = LotTenderResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
