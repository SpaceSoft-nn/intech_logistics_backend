<?php

namespace App\Modules\Auth\Domain\Resources\Phone;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

//Коллекция возврата всех организаций у user по phone
class OrganizationLoginCollection extends ResourceCollection
{

    public $collects = OrganizationLoginResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

}
