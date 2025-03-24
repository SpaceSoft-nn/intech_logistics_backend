<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderUnitStatusCollection extends ResourceCollection
{

    public $collects = OrderUnitStatusResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

}
