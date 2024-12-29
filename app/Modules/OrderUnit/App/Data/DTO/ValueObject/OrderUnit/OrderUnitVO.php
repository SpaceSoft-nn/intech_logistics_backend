<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use Illuminate\Contracts\Support\Arrayable;
use Arr;

class OrderUnitVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public readonly string $end_date_order,
        public readonly ?float $body_volume,
        public readonly string $order_total,

        public readonly TypeTransportWeight $type_transport_weight,
        public readonly TypeLoadingTruckMethod $type_load_truck,
        public ?StatusOrderUnitEnum $order_status,

        public ?string $description,

        public readonly string $organization_id,
        public ?string $user_id,
        public ?string $contractor_id,

        public ?bool $add_load_space,
        public ?bool $change_price,
        public ?bool $change_time,
        public ?string $lot_tender_id, // Если заказ создаётся по бизнес-логики Тендера

    ) {}

    public static function make(

        ?float $body_volume,
        string $order_total,
        string $end_date_order,

        string $type_load_truck,
        string $type_transport_weight,

        ?string $description = null,
        ?string $order_status = null,

        ?string $user_id = null,
        ?string $contractor_id = null,
        ?string $organization_id,

        bool $add_load_space,
        ?bool $change_price = null,
        ?bool $change_time = null,
        ?string $lot_tender_id = null,

    ) : self {

        return new self(

            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,
            end_date_order: $end_date_order,

            type_load_truck: TypeLoadingTruckMethod::stringByCaseToObject($type_load_truck),
            type_transport_weight: TypeTransportWeight::stringByCaseToObject($type_transport_weight),
            order_status: StatusOrderUnitEnum::stringByCaseToObject($order_status),

            user_id: $user_id,
            contractor_id: $contractor_id,
            organization_id: $organization_id,

            add_load_space: $add_load_space,
            change_price: $change_price,
            change_time: $change_time,
            lot_tender_id: $lot_tender_id,

        );

    }


    /**
     * VO - Должен сохранять иммутабельность, поэтому делаем новый объект с заполненным полям
     * @return self
     */
    public function withBodyVolume(float $body_volume) : self
    {
        return new self (
            body_volume: $body_volume,
            order_total: $this->order_total,
            description: $this->description,
            end_date_order: $this->end_date_order,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $this->contractor_id,
            organization_id: $this->organization_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
        );
    }

    /**
    * VO - Должен сохранять иммутабельность, поэтому делаем новый объект с заполненным полям
    * @return self
    */
    public function setContractorId(string $contractor_id) : self
    {
        return new self (
            body_volume: $this->body_volume,
            order_total: $this->order_total,
            description: $this->description,
            end_date_order: $this->end_date_order,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $contractor_id,
            organization_id: $this->organization_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
        );
    }


    public function setOrganizationId(string $organization_id) : self
    {
        return new self (
            body_volume: $this->body_volume,
            order_total: $this->order_total,
            description: $this->description,
            end_date_order: $this->end_date_order,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $this->contractor_id,
            organization_id: $organization_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
        );
    }

    public function toArray() : array
    {
        return [

            "end_date_order" => $this->end_date_order,
            "body_volume" => $this->body_volume,
            "order_total" => $this->order_total,
            "description" => $this->description,

            "type_load_truck" => $this->type_load_truck?->value,
            "type_transport_weight" => $this->type_transport_weight?->value,
            "order_status" => $this->order_status?->value,

            "user_id" => $this->user_id,
            "contractor_id" => $this->contractor_id,
            "organization_id" => $this->organization_id,

            //служебные
            "add_load_space" => $this->add_load_space,
            "change_price" => $this->change_price,
            "change_time" => $this->change_time,
            "lot_tender_id "=> $this->lot_tender_id,

        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        $end_date_order = Arr::get($data, "end_date_order");
        $body_volume = Arr::get($data, "body_volume", null);
        $order_total = Arr::get($data, "order_total");
        $description = Arr::get($data, "description", null);

        $type_load_truck = Arr::get($data, "type_load_truck");
        $type_transport_weight = Arr::get($data, "type_transport_weight");
        $order_status = Arr::get($data, "order_status", null);

        $user_id = Arr::get($data, "user_id", null);
        $contractor_id = Arr::get($data, "contractor_id", null);
        $organization_id = Arr::get($data, "organization_id", null);

        $change_price = Arr::get($data, "change_price", null);
        $change_time = Arr::get($data, "change_time", null);
        $lot_tender_id = Arr::get($data, "lot_tender_id" ,'null');

        return static::make(
            end_date_order: $end_date_order,
            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,

            type_load_truck: $type_load_truck,
            type_transport_weight: $type_transport_weight,
            order_status: $order_status,

            user_id: $user_id,
            contractor_id: $contractor_id,
            organization_id: $organization_id,

            add_load_space: self::filterEnumTypeLoad($type_load_truck),
            change_price: $change_price,
            change_time: $change_time,
            lot_tender_id: $lot_tender_id,
        );
    }

    /**
     * Проверяем если загрузка ltl, то add_load_space = true
     * @param string $value
     *
     */
    public static function filterEnumTypeLoad(string $value)
    {

        $enumObject = TypeLoadingTruckMethod::stringByCaseToObject($value);

        return ($enumObject === TypeLoadingTruckMethod::ltl) ? true : false;
    }
}
