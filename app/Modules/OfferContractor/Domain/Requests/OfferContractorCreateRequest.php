<?php

namespace App\Modules\OfferContractor\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;

class OfferContractorCreateRequest extends ApiRequest
{

    // protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        #TODO Проверять что пользователь который обратился на endpoint относится к оргиназции (перевозчика)
        return true;
    }


    public function rules(): array
    {
        return [
            'city_name_start' => ['required', 'string' , 'min:2'],
            'city_name_end' => ['required', 'string', 'min:2'],
            'price_for_distance' => ['required', 'numeric'],
            'transport_id' => ['required', 'uuid', 'exists:transports,id'],
            'user_id' => ['required',  'uuid', 'exists:users,id'],
            'organization_id' => ['required',  'uuid', 'exists:organizations,id'],
            'add_load_space' => ['nullable', 'boolean'],
            'road_back' => ['nullable', 'boolean'],
            'directly_road' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', "max:1000"],
        ];
    }

    public function createOfferContractorVO() : OfferContractorVO
    {
        return OfferContractorVO::fromArrayToObject($this->validated());
    }

}
