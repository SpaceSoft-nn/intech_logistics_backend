<?php

namespace App\Modules\Transfer\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;

class TransferCreateRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "main_order" => ['required', 'uuid'],

            //Нужна ли логика создание трансфера из множество заказов
            // "id_order_array" => ['required', 'array'],
            //'id_order_array.*' => ['required', 'uuid', 'exists:order_units,id'], //делать проверку?
            // 'id_order_array.*' => ['required', 'uuid'],

            "agreement_order_accept_id" => ['required', 'uuid'],
        ];
    }

}
