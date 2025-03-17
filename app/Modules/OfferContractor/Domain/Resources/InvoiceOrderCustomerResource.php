<?php

namespace App\Modules\OfferContractor\Domain\Resources;

use App\Modules\Address\Domain\Resources\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceOrderCustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [

            "id" => $this->id,
            "order_total" => $this->order_total,
            "description" => $this->description,
            "type_transport_weight" => $this->type_transport_weight,
            "type_load_truck" => $this->type_load_truck,
            "start_address_id" => AddressResource::make($this->start_address),
            "end_address_id" => AddressResource::make($this->end_address),
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "cargo_good" => $this->cargo_good,
            "organization_creator_id" => $this->organization_creator_id,

        ];
    }
}
