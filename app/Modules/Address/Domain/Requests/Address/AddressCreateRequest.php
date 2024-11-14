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
            "region" => ['required', 'string' ],
            "city" => ['required', 'string'],
            "street" => ['required', 'string'],
            "latitude" => ['required', "numeric", 'between:-90,90'],
            "longitude" => ['required', "numeric", 'between:-180,180'],
            "building" => ['nullable', 'string', "max:50"],
            "apartament" => ['nullable', 'string', "max:50"],
            "postal_code" => ['nullable', 'string', "max:20"],
            "type_address" => ['nullable', 'string', "max:50"]
        ];

    }

    public function getAddressVO() : AddressVO
    {
        return AddressVO::returnObjectFromArray($this->validated());
    }

}
