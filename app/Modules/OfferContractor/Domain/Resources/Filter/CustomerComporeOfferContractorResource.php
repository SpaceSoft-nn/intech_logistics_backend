<?php

namespace App\Modules\OfferContractor\Domain\Resources\Filter;

use App\Modules\OfferContractor\Domain\Resources\OfferContractorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerComporeOfferContractorResource extends OfferContractorResource
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
