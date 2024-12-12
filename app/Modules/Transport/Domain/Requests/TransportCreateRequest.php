<?php

namespace App\Modules\Transport\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\App\Data\Enums\TransportBodyType;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use Illuminate\Validation\Rule;

class TransportCreateRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        $type_loading = array_column(TransportLoadingType::cases(), 'name');
        $type_weight = array_column(TransportTypeWeight::cases(), 'name');
        $type_body = array_column(TransportBodyType::cases(), 'name');
        $type_status = array_column(TransportStatusEnum::cases(), 'name');

        return [

            "brand_model" => ['required', 'string', 'max:100'],
            "year" => ['required', 'numeric'],
            "transport_number" => ['required', 'string', 'max:9'],
            "body_volume" => ['required', 'numeric', 'min:1'],
            "body_weight" => ['required', 'numeric', 'min:0'],


            "type_loading" => ['required', Rule::in($type_loading) ],
            "type_weight" => ['required', Rule::in($type_weight) ],
            "type_body" => ['required', Rule::in($type_body) ],
            "type_status" => ['required', Rule::in($type_status) ],

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
