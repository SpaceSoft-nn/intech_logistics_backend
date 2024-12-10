<?php

namespace App\Modules\Transport\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeEnum;
use Illuminate\Validation\Rule;

class TransportCreateRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        $typeTransportEnum = array_column(TransportTypeEnum::cases(), 'name');
        $transportStatusEnum = array_column(TransportStatusEnum::cases(), 'name');

        return [

            "type" => ['required', Rule::in($typeTransportEnum) ],
            "brand_model" => ['required', 'string', 'max:100'],
            "year" => ['required', 'numeric'],
            "transport_number" => ['required', 'string', 'max:9'],
            "body_volume" => ['required', 'numeric'],
            "body_weight" => ['required', 'numeric'],
            "type_status" => ['required', Rule::in($transportStatusEnum) ],
            "organization_id" => ['required', 'uuid', "exists:organizations,id"],
            "driver_id" => ['nullable', 'uuid'],
            "description" => ['nullable', 'string', 'max:255'],

        ];
    }

    /**
    * @return TransportVO
    */
    public function createTransportVO(): TransportVO
    {
        return TransportVO::fromArrayToObject($this->validated());
    }
}
