<?php

namespace App\Modules\Tender\Domain\Resources\Response;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LotTenderResponseCollection extends ResourceCollection
{
    public $collects = LotTenderResponseResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
