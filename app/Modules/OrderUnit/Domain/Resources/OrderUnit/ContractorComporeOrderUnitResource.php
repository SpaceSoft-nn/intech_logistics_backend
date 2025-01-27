<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use App\Modules\Address\Domain\Resources\AddressCollection;
use App\Modules\OrderUnit\Domain\Resources\CargoGood\CargoGoodCollection;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractorComporeOrderUnitResource extends JsonResource
{


    public function toArray(Request $request): array
    {

        return [

            "id" => $this['id'],
            "number" => $this['number_order'],

            "end_date_order" => $this['end_date_order'] ? $this['end_date_order'] : null,
            "exemplary_date_start" => $this['exemplary_date_start'] ? $this['exemplary_date_start'] : null,

            "body_volume" => $this['body_volume'],
            "order_total" => $this['order_total'],
            "description" => $this['description'],

            'end_date_delivery' => $this['end_date_order'], #TODO Сделано абстракция - если нужно потом доделать.

            "type_transport_weight" => $this['type_transport_weight'],
            "cargo_unit_sum" => $this['cargo_unit_sum'],
            "type_load_truck" => $this['type_load_truck'],

            'cargo_goods' => isset($this['cargo_goods']) ? CargoGoodCollection::make( $this['cargo_goods'] ) : null,

            'address_array' => isset($this['addresses']) ? AddressCollection::make(resource: $this['addresses'], idOrderUnit: $this['id']) : null,

            //bool
                "add_load_space" => $this['add_load_space'],
                "change_price" => $this['change_price'],
                "change_time" => $this['change_time'],
                "address_is_array" => $this['address_is_array'],
                "goods_is_array" => $this['goods_is_array'],
            //

            "order_status" => $this['actual_status'],

            "user_id" => UserResource::make(User::find($this['user_id'])),
            "organization_id" => OrganizationResource::make(Organization::find($this['organization_id'])),

            //Tender
            "lot_tender_id" => $this['lot_tender_id'],
            //

            'isResponseContractor' => $this['isResponseContractor'],

        ];
    }
}

// 'order' => OrderUnitResource::make($this['order']),
// 'isResponseContractor' => $this['isResponseContractor'],
