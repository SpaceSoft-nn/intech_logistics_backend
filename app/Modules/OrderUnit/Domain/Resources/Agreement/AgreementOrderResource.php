<?php

namespace App\Modules\OrderUnit\Domain\Resources\Agreement;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources\InvoceOrderResource;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitResource;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementOrderResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "order" => OrderUnitResource::make($this->order),
            "organization_contractor" => OrganizationResource::make($this->organization),
            "contractor_invoice" => InvoceOrderResource::make($this->invoiceOrder),
            "agreement_order_accept" => AgreementOrderAcceptResource::make($this->agreementOrderAccept),
        ];
    }
}
