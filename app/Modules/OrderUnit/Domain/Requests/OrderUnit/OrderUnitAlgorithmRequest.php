<?php

namespace App\Modules\OrderUnit\Domain\Requests\OrderUnit;

use App\Modules\Base\Requests\ApiRequest;

class OrderUnitAlgorithmRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "main_order" => ['required', 'uuid', "exists:order_units,id"],
            "search_distance" => ['nullable', 'integer'],
        ];
    }


}
