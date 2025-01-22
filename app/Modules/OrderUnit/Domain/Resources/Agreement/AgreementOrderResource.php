<?php

namespace App\Modules\OrderUnit\Domain\Resources\Agreement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementOrderResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id_agreement_order" => $this->id,
            "order_unit_id" => $this->order_unit_id,
            "organization_contractor_id" => $this->organization_contractor_id,
            "organization_order_units_invoce_id" => $this->orgOrdertInvoices,
            "agreement_order_accept_id" => $this->agreementOrderAccept,
        ];
    }
}
    