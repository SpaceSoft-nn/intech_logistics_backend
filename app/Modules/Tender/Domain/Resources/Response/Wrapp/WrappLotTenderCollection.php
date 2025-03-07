<?php

namespace App\Modules\Tender\Domain\Resources\Response\Wrapp;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WrappLotTenderCollection extends ResourceCollection
{

    public $collects = WrappLotTenderResource::class;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

}
