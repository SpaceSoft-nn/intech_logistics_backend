<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Base\Enums\WeekEnum;
use App\Modules\Base\Error\BusinessException;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\Tender\App\Data\Enums\TypeTenderEnum;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;

class CreateLotTenderRequest extends ApiRequest
{

    public function __construct(
        private ?array $validated = null,
    ) {
        // parent::__construct();
    }


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $typeLoadingTruckMethod = array_column(TypeLoadingTruckMethod::cases(), 'name');
        $typeTransportWeight = array_column(TypeTransportWeight::cases(), 'name');
        $typeTender = array_column(TypeTenderEnum::cases(), 'name');
        $week = array_column(WeekEnum::cases(), 'name');

        return [

            'general_count_transport' => ['required' , 'integer'],
            'price_for_km' => ['required' , 'numeric', 'min:1'],
            'body_volume_for_order' => ['required' , 'numeric', 'min:1'],

            'type_transport_weight' => ['required' , Rule::in($typeTransportWeight)],
            'type_load_truck' => ['required' , Rule::in($typeLoadingTruckMethod)],

            'type_tender' => ['required' , Rule::in($typeTender)],

            'date_start' => ['required' , 'date', 'date_format:d.m.Y'],
            'organization_id' => ['required' , 'uuid', 'exists:organizations,id'],

            'period' => ['required' , 'integer'],


            'week_period' => ['required_if:type_tender,periodic' , 'prohibited_if:type_tender,single', 'array', Rule::in($week), 'distinct:strict'],
            // 'week_period.*.week' => ['required', Rule::in($week), 'distinct:strict'],

            'agreement_document' => ['required', File::types(['pdf', 'doc', 'docx', 'rtf', 'odt'])->max(16384)],

            'application_document' => ['nullable', 'array'],
            'application_document*' => ['required', File::types(['pdf', 'doc', 'docx', 'rtf', 'odt'])->max(16384)],

            'specific_date_periods' => ['required_if:type_tender,single', 'array', 'prohibited_if:type_tender,periodic'],
            'specific_date_periods.*.date' => ['required',  'date', 'date_format:d.m.Y'],
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

        return isset($data['agreement_document']) && !is_null(isset($data['agreement_document'])) ? $data['agreement_document'] : throw new BusinessException('а', 422);
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

    public function getArrayWeekPeriod() : ?array
    {
        //вызываем 1 раз $this->validate(), что бюы его запомнить в переменную и не вызывать в других функциях по новой
        $data = $this->validated ?? $this->validated();

        $array = [];

        if(isset($data['week_period']) && !is_null(isset($data['week_period'])))
        {
            foreach ($data['week_period'] as $item) {
                $array[] = WeekEnum::stringByCaseToObject($item);
            }

        } else {

            return null;

        }

        return $array;
    }

}
