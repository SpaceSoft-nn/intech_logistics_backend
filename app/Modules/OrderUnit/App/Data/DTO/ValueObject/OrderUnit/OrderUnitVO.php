<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

class OrderUnitVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(


        public readonly string $body_volume,
        public readonly string $order_total,
        public readonly string $organization_id,
        public readonly TypeLoadingTruckMethod $type_load_truck,
        public readonly string $end_date_order,
        public ?string $description,
        public ?string $product_type,
        public ?StatusOrderUnitEnum $order_status,
        public ?string $user_id,
        public ?bool $add_load_space,
        public ?bool $change_price,
        public ?bool $change_time,

    ) {}

    public static function make(

        string $body_volume,
        string $order_total,
        string $description,
        string $organization_id,
        string $type_load_truck,
        string $end_date_order,
        ?string $product_type = null,
        ?StatusOrderUnitEnum $order_status = null,
        ?string $user_id = null,
        ?bool $add_load_space = null,
        ?bool $change_price = null,
        ?bool $change_time = null,

    ) : self {

        return new self(

            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,
            end_date_order: $end_date_order,
            product_type: $product_type,
            type_load_truck: TypeLoadingTruckMethod::stringByCaseToObject($type_load_truck),
            order_status: $order_status,
            user_id: $user_id,
            organization_id: $organization_id,
            add_load_space: $add_load_space,
            change_price: $change_price,
            change_time: $change_time,

        );

    }


    public function toArray() : array
    {
        return [

            "end_date_order" => $this->end_date_order,
            "body_volume" => $this->body_volume,
            "order_total" => $this->order_total,
            "description" => $this->description,
            "product_type" => $this->product_type,
            "type_load_truck" => $this->type_load_truck,
            "order_status" => $this->order_status,
            "user_id" => $this->user_id,
            "organization_id" => $this->organization_id,
            "add_load_space" => $this->add_load_space,
            "change_price" => $this->change_price,
            "change_time" => $this->change_time,

        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        $end_date_order = Arr::get($data, "end_date_order");
        $body_volume = Arr::get($data, "body_volume");
        $order_total = Arr::get($data, "order_total");
        $organization_id = Arr::get($data, "organization_id");
        $type_load_truck = Arr::get($data, "type_load_truck");
        $description = Arr::get($data, "description", null);
        $product_type = Arr::get($data, "product_type", null);
        $order_status = Arr::get($data, "order_status", null);
        $user_id = Arr::get($data, "user_id", null);
        $change_price = Arr::get($data, "change_price", null);
        $change_time = Arr::get($data, "change_time", null);

        return new self(
            end_date_order: $end_date_order,
            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,
            product_type: $product_type,
            type_load_truck: TypeLoadingTruckMethod::stringByCaseToObject($type_load_truck),
            order_status: $order_status,
            user_id: $user_id,
            organization_id: $organization_id,
            add_load_space: self::filterEnumTypeLoad($type_load_truck),
            change_price: $change_price,
            change_time: $change_time,
        );
    }

    /**
     * Проверяем если загрузка ltl, то add_load_space = true
     * @param string $value
     *
     * @return [type]
     */
    public static function filterEnumTypeLoad(string $value)
    {
        $enumObject = TypeLoadingTruckMethod::stringByCaseToObject($value);

        return ($enumObject === TypeLoadingTruckMethod::ltl) ? true : false;
    }
}
