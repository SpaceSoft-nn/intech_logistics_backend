<?php

namespace App\Modules\IndividualPeople\Domain\Resources\TypePeople;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DriverPeopleCollection extends ResourceCollection
{
    public $collects = DriverPeopleResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
