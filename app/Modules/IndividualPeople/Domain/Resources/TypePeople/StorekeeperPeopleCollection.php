<?php

namespace App\Modules\IndividualPeople\Domain\Resources\TypePeople;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StorekeeperPeopleCollection extends ResourceCollection
{
    public $collects = StorekeeperPeopleResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
