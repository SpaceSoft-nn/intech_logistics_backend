<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use Illuminate\Http\Request;


class ContractorComporeOrderUnitResource extends OrderUnitResource
{

    public function toArray(Request $request): array
    {
        //записываем значение в переменную
        $isResponseContractor = $this->isResponseContractor;
        $countResponse = $this->organization_order_unit_invoices;

        //наследуем основной шаблон json resource order
        $data = parent::toArray($request);

        $data = array_merge($data, ['isResponseContractor' => $isResponseContractor]);

        //количество записей отклика на заказ, от перевозчиков
        $data = array_merge($data, ['count_response' => $countResponse]);

        return $data;
    }
}

