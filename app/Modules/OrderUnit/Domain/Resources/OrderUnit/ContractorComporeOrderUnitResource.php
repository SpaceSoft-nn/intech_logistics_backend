<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use Illuminate\Http\Request;


class ContractorComporeOrderUnitResource extends OrderUnitResource
{

    public function toArray(Request $request): array
    {
        //записываем значение в переменную
        $isResponseContractor = $this->isResponseContractor;

        //наследуем основной шаблон json resource order
        $data = parent::toArray($request);

        $data = array_merge($data, ['isResponseContractor' => $isResponseContractor]);

        return $data;
    }
}

