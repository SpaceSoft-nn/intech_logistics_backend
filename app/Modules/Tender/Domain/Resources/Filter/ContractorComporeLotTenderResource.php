<?php

namespace App\Modules\Tender\Domain\Resources\Filter;

use App\Modules\Tender\Domain\Resources\LotTenderResource;
use Illuminate\Http\Request;


class ContractorComporeLotTenderResource extends LotTenderResource
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

