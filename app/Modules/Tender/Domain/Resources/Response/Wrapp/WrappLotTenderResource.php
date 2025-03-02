<?php

namespace App\Modules\Tender\Domain\Resources\Response\Wrapp;

use App\Modules\Tender\Domain\Resources\LotTenderResource;
use Illuminate\Http\Request;

//Wrap OrderUnitResource для добавление дополнительных полей в зависимости от бизнес задачи на разные endpoint (при этом не модифицируя OrderUnitResoruce)
class WrappLotTenderResource extends LotTenderResource
{

    public function toArray(Request $request): array
    {

        //записываем значение в переменную
        $countResponse = $this->lot_tender_response->isEmpty() ? 0 : $this->lot_tender_response->count();

        //наследуем основной шаблон json resource order
        $data = parent::toArray($request);

        //количество записей отклика на заказ, от перевозчиков
        $data = array_merge($data, ['count_response' => $countResponse]);

        return $data;
    }
}

