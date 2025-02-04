<?php

namespace App\Modules\User\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserHasOrganizationCollection extends ResourceCollection
{

    public $collects = UserHasOrganizationResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

}
