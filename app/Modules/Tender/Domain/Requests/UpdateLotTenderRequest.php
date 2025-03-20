<?php

namespace App\Modules\Tender\Domain\Requests;

use Illuminate\Validation\Rule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Tender\App\Data\DTO\UpdateLotTenderDTO;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;

class UpdateLotTenderRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // Берём только те поля, которые участвуют в обновлении
            $data = array_filter($this->only(
                [ 'general_count_transport',
                'price_for_km',
                'body_volume_for_order',
                'status_tender',
                'type_transport_weight',
                'type_load_truck',])
            );

            if (empty($data)) {
                $validator->errors()->add('request', 'Необходимо указать хотя бы одно поле для обновления.');
            }

        });
    }

    public function rules(): array
    {

        $typeLoadingTruckMethod = array_column(TypeLoadingTruckMethod::cases(), 'name');
        $typeTransportWeight = array_column(TypeTransportWeight::cases(), 'name');
        $status = array_column(StatusTenderEnum::cases(), 'name');

        return [

            'general_count_transport' => ['nullable' , 'integer'],
            'price_for_km' => ['nullable' , 'numeric', 'min:1'],
            'body_volume_for_order' => ['nullable' , 'numeric', 'min:1'],
            'status_tender' => ['nullable', Rule::in($status)],

            'type_transport_weight' => ['nullable' , Rule::in($typeTransportWeight)],
            'type_load_truck' => ['nullable' , Rule::in($typeLoadingTruckMethod)],

        ];

    }

    public function createUpdateLotTenderDTO() : UpdateLotTenderDTO
    {
        return UpdateLotTenderDTO::fromArrayToObject($this->validated());
    }



}
