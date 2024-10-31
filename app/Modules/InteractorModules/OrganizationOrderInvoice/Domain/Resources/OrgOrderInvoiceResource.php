<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources;

use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitResource;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrgOrderInvoiceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            //#TODO Решить какими данными отвечать
            "id" => $this->id,
            "organization_contract" => OrganizationResource::make($this->organization),
            "order" => OrderUnitResource::make($this->order_unit),
            "invoice_order" => InvoceOrderResource::make($this->invoice_order),

        ];
    }
}
