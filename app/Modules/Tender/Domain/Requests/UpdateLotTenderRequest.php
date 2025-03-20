<?php

namespace App\Modules\Tender\Domain\Requests;

use Illuminate\Validation\Rule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;


class UpdateLotTenderRequest extends ApiRequest
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

    public function createLotTenderVO() : LotTenderVO
    {

        //вызываем 1 раз $this->validate(), что бюы его запомнить в переменную и не вызывать в других функциях по новой
        $data = $this->validated ?? $this->validated();

        return LotTenderVO::fromArrayToObject($data);
    }

    public function createLotTenderVOBy() : LotTenderVO
    {

        //вызываем 1 раз $this->validate(), что бюы его запомнить в переменную и не вызывать в других функциях по новой
        $data = $this->validated ?? $this->validated();

        return LotTenderVO::fromArrayToObject($data);
    }


}
