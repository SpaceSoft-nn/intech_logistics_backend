<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OredUnitCollection extends ResourceCollection
{

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = OredUnitResource::class;

    public function toArray(Request $request): array
    {
        return [
            'collections' => $this->collection,
            'total' =>  $this->collection->count(),
        ];
    }
}
