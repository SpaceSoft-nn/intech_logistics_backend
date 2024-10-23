<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\User\Domain\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderUnitResource extends JsonResource
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
            "body_volume" => $this->body_volume,
            "order_total" => $this->order_total,

            "type_load_truck" => $this->type_load_truck,
            "end_date_order" => $this->end_date_order,

            //bool
                "add_load_space" => $this->add_load_space,
                "change_price" => $this->change_price,
                "change_time" => $this->change_time,
            //

            "description" => $this->description,
            "product_type" => $this->product_type,
            "order_status" => $this->order_status,
            "user_id" => UserResource::make($this->user),
            "organization_id" => OrganizationResource::make($this->organization),

        ];
    }
}
