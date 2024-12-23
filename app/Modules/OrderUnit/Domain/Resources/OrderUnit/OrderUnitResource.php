<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use App\Modules\Address\Domain\Resources\AddressCollection;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Resources\CargoGood\CargoGoodCollection;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\User\Domain\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderUnitResource extends JsonResource
{

    public function __construct(
        public OrderUnitRepository $rep
    ) { }


    public function toArray(Request $request): array
    {
        //Обновляем, что бы получить актуальные данные из бд
        $this->refresh();

        // Загружаем отношения что бы не было проблемы N + 1
        $this->loadMissing([
            'cargo_goods',
            'addresses',
        ]);

        return [

            "id" => $this->id,
            "end_date_order" => $this->end_date_order ? $this->end_date_order->format('Y-m-d') : null,
            "body_volume" => $this->body_volume,
            "order_total" => $this->order_total,
            "description" => $this->description,

            'end_date_delivery' => $this->end_date_order,

            "type_transport_weight" => $this->type_load_truck,
            "cargo_unit_sum" => $this->cargo_unit_sum,
            "type_load_truck" => $this->type_load_truck,

            'cargo_goods' => CargoGoodCollection::make($this->cargo_goods),

            'address_array' => AddressCollection::make(resource: $this->addresses, idOrderUnit: $this->id),

            //bool
                "add_load_space" => $this->add_load_space,
                "change_price" => $this->change_price,
                "change_time" => $this->change_time,
                "address_is_array" => $this->address_is_array,
                "goods_is_array" => $this->goods_is_array,
            //

            "order_status" => $this->actual_status->status,
            "transportation_status" => $this->rep->getActualTransportationStatus($this->id), //при помощи репозитория получаем актуальный статус

            "user_id" => UserResource::make($this->user),
            "organization_id" => OrganizationResource::make($this->organization),

        ];
    }
}
