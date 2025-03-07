<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;

class AddContractorRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            "transport_id" => ['required', 'uuid', "exists:transports,id"],
            "price" => ['nullable', 'numeric'],
            "date" => ['nullable', 'date', 'date_format:d.m.Y'],
            "comment" => [ 'nullable', 'string', 'max:1000'],

        ];
    }

    /**
    * @return InvoiceOrderVO
    */
    public function getValueObject(): InvoiceOrderVO
    {
        return InvoiceOrderVO::fromArrayToObject($this->validated());
    }
}
