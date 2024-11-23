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

            // 'json' => ['required', 'json'],
            // "region" => ['required', 'string' ],
            // "city" => ['required', 'string'],
            // "street" => ['required', 'string'],
            // "latitude" => ['required', "numeric", 'between:-90,90'],
            // "longitude" => ['required', "numeric", 'between:-180,180'],
            // "building" => ['nullable', 'string', "max:50"],
            // "apartament" => ['nullable', 'string', "max:50"],
            // "postal_code" => ['nullable', 'string', "max:20"],
            // "type_address" => ['nullable', 'string', "max:50"]

            'data' => ['required', 'array'],
            'data.data*' => ['required', 'array'],

            'data.data.postal_code' => ['sometimes', 'string'],
            // 'data.data.country' => ['required', 'string'],
            'data.data.city_with_type' => ['required', 'string'],
            'data.data.region' => ['required', 'string'],
            'data.data.street_with_type' => ['required', 'string'],
            'data.data.house_type_full' => ['sometimes', 'string'],
            'data.data.house' => ['sometimes', 'string'],
            'data.data.geo_lat' => ['required', 'string'],
            'data.data.geo_lon' => ['required', 'string'],

            'data.unrestricted_value' => ['nullable', 'string'],
            'data.value' => ['nullable', 'string'],

            // "region" => ['required', 'string' ],
            // "city" => ['required', 'string'],
            // "street" => ['required', 'string'],
            // "latitude" => ['required', "numeric", 'between:-90,90'],
            // "longitude" => ['required', "numeric", 'between:-180,180'],
            // "building" => ['nullable', 'string', "max:50"],
            // "apartament" => ['nullable', 'string', "max:50"],
            // "postal_code" => ['nullable', 'string', "max:20"],
            // "type_address" => ['nullable', 'string', "max:50"]
        ];

    }

    public function getAddressVO() : AddressVO
    {
        return AddressVO::returnObjectFromArray($this->validated())->setJson($this->all());
    }

}
