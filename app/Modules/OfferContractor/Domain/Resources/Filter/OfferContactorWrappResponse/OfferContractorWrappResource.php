<?php

namespace App\Modules\OfferContractor\Domain\Resources\Filter\OfferContactorWrappResponse;

use App\Modules\OfferContractor\Domain\Resources\OfferContractorResource;
use Illuminate\Http\Request;

//Wrap OfferContractorWrappResource для добавление дополнительных полей в зависимости от бизнес задачи на разные endpoint (при этом не модифицируя OfferContractorResource)
class OfferContractorWrappResource extends OfferContractorResource
{

    public function toArray(Request $request): array
    {

        //записываем значение в переменную
        $countResponse = $this->offer_contractor_customer->isEmpty() ? 0 : $this->offer_contractor_customer->count();

        //наследуем основной шаблон json resource order
        $data = parent::toArray($request);

        //количество записей отклика на заказ, от заказчиков на предложения перевозчика
        $data = array_merge($data, ['count_response' => $countResponse]);

        return $data;
    }
}

