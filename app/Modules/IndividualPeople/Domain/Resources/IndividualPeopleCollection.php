<?php

namespace App\Modules\IndividualPeople\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndividualPeopleCollection extends ResourceCollection
{
    public $collects = IndividualPeopleResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
