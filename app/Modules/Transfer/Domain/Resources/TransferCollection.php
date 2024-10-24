<?php

namespace App\Modules\Transfer\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransferCollection extends ResourceCollection
{

    public $collects = TransferResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
