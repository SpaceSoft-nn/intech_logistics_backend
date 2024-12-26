<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;

class CreateLotTenderRequest extends ApiRequest
{

    public function __construct(
        private ?array $validated = null,
    ) {
        parent::__construct();
    }


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
            'price_for_km' => ['required' , 'numeric', 'min:1'],
            'body_volume_for_order' => ['required' , 'numeric', 'min:1'],

            'type_transport_weight' => ['required' , Rule::in($typeTransportWeight)],
            'type_load_truck' => ['required' , Rule::in($typeLoadingTruckMethod)],

            'date_start' => ['required' , 'date'],
            'organization_id' => ['required' , 'uuid', 'exists:organizations,id'],

            'period' => ['required' , 'integer'],
            'day_period' => ['required' , 'integer'],

            'agreement_document' => ['required', File::types(['pdf', 'doc', 'docx', 'rtf', 'odt'])->max(16384)],

            'application_document' => ['nullable', 'array'],
            'application_document*' => ['required', File::types(['pdf', 'doc', 'docx', 'rtf', 'odt'])->max(16384)],

            'specific_date_periods' => ['nullable', 'array'],
            'specific_date_periods.*.date' => ['required', 'date'],
            'specific_date_periods.*.count_transport' => ['required', 'integer'],

        ];


    }

    public function createLotTenderVO() : LotTenderVO
    {

        //вызываем 1 раз $this->validate(), что бюы его запомнить в переменную и не вызывать в других функциях по новой
        $data = $this->validated ?? $this->validated();

        return LotTenderVO::fromArrayToObject($data);
    }

    public function getArrayAgreementDocumentTender() : UploadedFile
    {
        //вызываем 1 раз $this->validate(), что бюы его запомнить в переменную и не вызывать в других функциях по новой
        $data = $this->validated ?? $this->validated();

        return isset($data['agreement_document']) && !is_null(isset($data['agreement_document'])) ? $data['agreement_document'] : null;

        return null;
    }

    /**
     * @return ?array
     */
    public function getArrayApplicationDocumentTender() : ? array
    {
        //вызываем 1 раз $this->validate(), что бюы его запомнить в переменную и не вызывать в других функциях по новой
        $data = $this->validated ?? $this->validated();

        return isset($data['application_document']) && !is_null(isset($data['application_document'])) ? $data['application_document'] : null;

        return null;
    }

    /**
     * @return ?array
     */
    public function getArraySpecificalDatePeriod() : ?array
    {

        //вызываем 1 раз $this->validate(), что бюы его запомнить в переменную и не вызывать в других функциях по новой
        $data = $this->validated ?? $this->validated();


        return isset($data['specific_date_periods']) && !is_null(isset($data['specific_date_periods'])) ? $data['specific_date_periods'] : null;

    }



}
