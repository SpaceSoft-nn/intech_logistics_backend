<?php

namespace App\Modules\Transport\Domain\Requests;

use Illuminate\Validation\Rule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Transport\Domain\Models\Transport;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\Transport\App\Data\Enums\TransportBodyType;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;

class TransportUpdateRequest extends ApiRequest
{

    public function authorize(
        GetTypeCabinetByOrganization $action
    ): bool {
        $status = $action->isCustomer();

        abort_if($status['status'], 401 ,'Данная организация не является перевозчиком');

        return true;
    }

    public function passes($attribute, $value): bool
    {
        // Проверка, что хотя бы одно поле было передано
        return !empty(array_filter($value));
    }


    public function rules(): array
    {

        $type_loading = array_column(TransportLoadingType::cases(), 'name');
        $type_weight = array_column(TransportTypeWeight::cases(), 'name');
        $type_body = array_column(TransportBodyType::cases(), 'name');
        $type_status = array_column(TransportStatusEnum::cases(), 'name');

        return [

            "brand_model" => ['sometimes', 'nullable', 'string', 'max:100'],
            "year" => ['sometimes', 'nullable', 'numeric'],
            "transport_number" => ['sometimes', 'nullable', 'string', 'max:9'],
            "body_volume" => ['sometimes', 'nullable', 'numeric', 'min:1'],
            "body_weight" => ['sometimes', 'nullable', 'numeric', 'min:0'],


            "type_loading" => ['sometimes', 'nullable', Rule::in($type_loading) ],
            "type_weight" => ['sometimes', 'nullable', Rule::in($type_weight) ],
            "type_body" => ['sometimes', 'nullable', Rule::in($type_body) ],
            "type_status" => ['sometimes', 'nullable', Rule::in($type_status) ],

            "driver_id" => ['sometimes', 'nullable', 'uuid', 'exists:driver_peoples,id'],
            "description" => ['sometimes', 'nullable', 'string', 'max:255'],

        ];
    }

    /**
    * @return TransportVO
    */
    public function createTransportVO(): TransportVO
    {
        return TransportVO::fromArrayToObject($this->validated());
    }

    /**
    * Получаем TransportVO для обновления
    * @return TransportVO
    */
    public function updateTransportVO(Transport $transport): TransportVO
    {
        return TransportVO::mappingForUpdate($transport, $this->validated());
    }
}
