<?php

namespace App\Modules\OrderUnit\Domain\Resources\CargoUnit;

use App\Modules\OrderUnit\Domain\Resources\CargoUnit\CargoUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CargoUnitCollection extends ResourceCollection
{

    public $collects = CargoUnitResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
