<?php

namespace App\Modules\Adress\Domain\Requests\Adress;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class AdressCreateRequest extends ApiRequest
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
            "building" => ['nullable', 'string', "max:50"],
            "apartment" => ['nullable', 'string', "max:50"],
            "house_number" => ['nullable', 'string', "max:50"],
            "postal_code" => ['nullable', 'string', "max:20"],
            "latitude" => ['required', "string"],
            "longitude" => ['required', "string"],
        ];
    }

}
