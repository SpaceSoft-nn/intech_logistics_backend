<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitWrapp;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderUnitWrappCollection extends ResourceCollection
{

    public $collects = OrderUnitWrappResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

}
