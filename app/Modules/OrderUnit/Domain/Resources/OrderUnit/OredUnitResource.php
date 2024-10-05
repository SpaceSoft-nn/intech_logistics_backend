<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use App\Modules\Adress\Domain\Resources\AdressResource;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\User\Domain\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OredUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "delivery_start" => $this->delivery_start,
            "delivery_end" => $this->delivery_end,
            "adress_start_id" => AdressResource::make($this->adress_start),
            "adress_end_id" => AdressResource::make($this->adress_end),
            "body_volume" => $this->body_volume,
            "order_total" => $this->order_total,
            "description" => $this->description,
            "product_type" => $this->product_type,
            "order_status" => $this->order_status,
            // "mgx_id" => $this->id,
            "user_id" => UserResource::make($this->user),
            "organization_id" => OrganizationResource::make($this->organization),
        ];
    }
}
