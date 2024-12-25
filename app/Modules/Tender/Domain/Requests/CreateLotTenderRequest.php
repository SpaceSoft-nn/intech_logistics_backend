<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class CreateLotTenderRequest extends ApiRequest
{
    public function authorize(AuthServiceInterface $auth): bool
    {
        return true;
    }

    public function rules(): array
    {

        $typeLoadingTruckMethod = array_column(TypeLoadingTruckMethod::cases(), 'name');
        $typeTransportWeight = array_column(TypeTransportWeight::cases(), 'name');

        return [

            'general_count_transport' => ['required' , 'integer'],
            'price_for_km' => ['required' , 'decimal:5,2'],
            'body_volume_for_order' => ['required' , 'integer'],

            'type_transport_weight' => ['required' , Rule::in($typeLoadingTruckMethod)],
            'type_load_truck' => ['required' , Rule::in($typeTransportWeight)],

            'date_start' => ['required' , 'date'],

            'period' => ['required' , 'integer'],
            'day_period' => ['required' , 'integer'],

            'agreement_document' => ['required', File::types(['pdf', 'doc', 'docx', 'rtf', 'odt'])->max(16384) ],

            'application_document' => ['nullable', 'array'],
            'application_document*' => ['required', File::types(['pdf', 'doc', 'docx', 'rtf', 'odt'])->max(16384)],

            'specific_date_periods' => ['nullable', 'array'],
            'specific_date_periods*' => ['required', 'date'],

        ];

    }



}
