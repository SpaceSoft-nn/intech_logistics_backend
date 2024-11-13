<?php

namespace App\Modules\Address\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressCollection extends ResourceCollection
{

    public $collects = AddressResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
