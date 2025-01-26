<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

//возвращаем сформированный ресурс, где указывается заказ и булевы стату означающий отклинкулся ли перевозчикн на этот заказ
class ContractorsCompareResource extends JsonResource
{


    public function toArray(Request $request): array
    {


        #TODO в load_type надо возвращать имя кейса
        return [

            'order' => OrderUnitResource::make($this['order']),
            'isResponseContractor' => $this['isResponseContractor'],

        ];
    }
}
