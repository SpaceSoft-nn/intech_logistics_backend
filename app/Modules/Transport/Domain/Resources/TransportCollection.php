<?php

namespace App\Modules\Transport\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransportCollection extends ResourceCollection
{
    public $collects = TransportResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
