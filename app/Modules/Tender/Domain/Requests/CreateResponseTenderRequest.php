<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\App\Data\ValueObject\Response\InvoiceLotTenderVO;

class CreateLotTenderRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [

            'transport_id' => ['required' , 'uuid', 'exists:transports,id'],
            'organization_contractor_id' => ['required' , 'uuid', 'exists:organizations,id'],
            'price_for_km' => ['required' , 'numeric', "min:1"],
            'lot_tender_response_id' => ['required' , 'uuid', "exists:lot_tender_responses,id"],
            'comment' => ['nullable' , 'string', "min:1000"],

        ];


    }

    public function createResponseTenderDTO() : CreateResponseTenderDTO
    {
        return CreateResponseTenderDTO::fromArrayToObject($this->validated());
    }



}
