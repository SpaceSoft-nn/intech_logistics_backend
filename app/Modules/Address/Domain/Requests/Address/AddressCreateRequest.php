<?php

namespace App\Modules\Address\Domain\Requests\Address;

use App\Modules\Address\App\Data\DTO\ValueObject\AddressVO;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Base\Traits\FilterArrayTrait;

class AddressCreateRequest extends ApiRequest
{

    use FilterArrayTrait;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    // ??
    public function rules(): array
    {
        return [

            'point_name' => ['nullable', 'string', 'min:1', "max:255"], //пункты (пользователь сам указывает наименование)
            'unrestricted_value' => ['nullable', 'string'],
            'data' => ['required', 'array'],
            'data.data*' => ['required', 'array'],

            'data.data.postal_code' => ['sometimes', 'string'],
            // 'data.country' => ['required', 'string'],
            'data.city' => ['required', 'string'],
            'data.region' => ['required', 'string'],
            'data.street' => ['required', 'string'],
            'data.house' => ['nullable', 'string'],
            // 'data.stead' => ['nullable', 'string'],
            'data.geo_lat' => ['required', 'string'],
            'data.geo_lon' => ['required', 'string'],

            'data.value' => ['nullable', 'string'],

        ];

    }

    public function getAddressVO() : AddressVO
    {

        return AddressVO::returnObjectFromArray($this->validated())->setJson($this->all());
    }

}
