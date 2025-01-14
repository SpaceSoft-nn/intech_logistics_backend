<?php

namespace App\Modules\Tender\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WeekPeriodCollection extends ResourceCollection
{

    public $collects = WeekPeriodResource::class;

    public function toArray(Request $request): array
    {
        //проходим по элементам, возвращаем только value, all - выводим массив как php
        return $this->collection->map(fn($resource) => $resource->value)->all();
    }
}
