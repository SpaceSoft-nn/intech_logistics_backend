<?php

namespace App\Modules\OrderUnit\Domain\Requests\OrderUnit;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use Illuminate\Validation\Rule;

class OrderUnitUpdateRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function passes($attribute, $value): bool
    {
        // Проверка, что хотя бы одно поле было передано
        return !empty(array_filter($value));
    }

    public function rules(): array
    {

        $statusEnum = array_column(StatusOrderUnitEnum::cases(), 'name');

        return [

            "change_price" => ['nullable', 'boolean'],
            "change_time" => ['nullable', 'boolean'],
            "order_status" => ['nullable' , Rule::in($statusEnum)]

        ];
    }

}
