<?php

namespace App\Modules\Transport\Domain\Requests;

use Illuminate\Validation\Rule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Transport\App\Data\Enums\TransportBodyType;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;

class TransportUpdateRequest extends ApiRequest
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

            "brand_model" => ['sometimes', 'string', 'max:100'],
            "year" => ['sometimes', 'numeric'],
            "transport_number" => ['sometimes', 'string', 'max:9'],
            "body_volume" => ['sometimes', 'numeric', 'min:1'],
            "body_weight" => ['sometimes', 'numeric', 'min:0'],


            "type_loading" => ['sometimes', Rule::in($type_loading) ],
            "type_weight" => ['sometimes', Rule::in($type_weight) ],
            "type_body" => ['sometimes', Rule::in($type_body) ],
            "type_status" => ['sometimes', Rule::in($type_status) ],

            "driver_id" => ['sometimes', 'uuid'],
            "description" => ['sometimes', 'string', 'max:255'],

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
