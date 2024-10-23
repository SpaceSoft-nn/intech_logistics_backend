<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;

class AddContractorRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            "price" => ['required', 'numeric'],
            "date" => ['required', 'date'],
            "comment" => [ 'required', 'string', 'max:1000'],

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
