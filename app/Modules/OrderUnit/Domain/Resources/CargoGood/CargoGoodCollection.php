<?php

namespace App\Modules\OrderUnit\Domain\Resources\CargoGood;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CargoGoodCollection extends ResourceCollection
{

    public $collects = CargoGoodResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
