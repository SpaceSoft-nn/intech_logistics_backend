<?php

namespace App\Modules\Organization\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationCollection extends ResourceCollection
{

    public $collects = OrganizationResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
