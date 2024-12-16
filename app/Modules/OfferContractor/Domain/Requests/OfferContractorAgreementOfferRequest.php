<?php

namespace App\Modules\OfferContractor\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;

class OfferContractorAgreementOfferRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'offer_contractor_customer_id' => ['required', 'uuid', 'exists:offer_contractor_invoice_order_customers,id']
        ];
    }


}
