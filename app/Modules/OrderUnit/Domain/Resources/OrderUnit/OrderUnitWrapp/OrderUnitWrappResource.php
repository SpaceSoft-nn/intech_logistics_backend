<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitWrapp;

use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitResource;
use Illuminate\Http\Request;

//Wrap OrderUnitResource для добавление дополнительных полей в зависимости от бизнес задачи на разные endpoint (при этом не модифицируя OrderUnitResoruce)
class OrderUnitWrappResource extends OrderUnitResource
{

    public function toArray(Request $request): array
    {

        //записываем значение в переменную
        $countResponse = $this->organization_order_unit_invoices->isEmpty() ? 0 : $this->organization_order_unit_invoices->count();

        //наследуем основной шаблон json resource order
        $data = parent::toArray($request);

        //количество записей отклика на заказ, от перевозчиков
        $data = array_merge($data, ['count_response' => $countResponse]);

        return $data;
    }
}

