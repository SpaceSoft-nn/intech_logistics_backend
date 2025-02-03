<?php

namespace App\Modules\OfferContractor\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OfferContractor\App\Data\Enums\OfferContractorStatusEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

readonly class OfferContractorVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $city_name_start,
        public string $city_name_end,

        public float $price_for_distance,

        public string $transport_id,
        public string $user_id,
        public string $organization_id,



        public bool $add_load_space, //Возможен ли догруз
        public bool $road_back, //Обратная дорога
        public bool $directly_road, //Прямая дорога

        public ?OfferContractorStatusEnum $status,
        public ?string $order_unit_id, #TODO Подумать нужно ли это указывать?
        public ?string $description,
    ) {}

    public static function make(
        string $city_name_start,
        string $city_name_end,
        float $price_for_distance,


        string $transport_id,
        string $user_id,
        string $organization_id,


        bool $add_load_space = false,
        bool $road_back = false,
        bool $directly_road = false,

        ?string $status = null,
        ?string $description = null,
        ?string $order_unit_id = null,
    ) : self {


        return new self(
            city_name_start: $city_name_start,
            city_name_end: $city_name_end,
            price_for_distance: $price_for_distance,
            transport_id: $transport_id,
            user_id: $user_id,
            organization_id: $organization_id,
            add_load_space: $add_load_space,
            road_back: $road_back,
            directly_road: $directly_road,

            status: OfferContractorStatusEnum::stringByCaseToObject($status),
            description: $description,
            order_unit_id: $order_unit_id,
        );

    }

    public function toArray() : array
    {
        return [
            "city_name_start" => $this->city_name_start,
            "city_name_end" => $this->city_name_end,
            "price_for_distance" => $this->price_for_distance,
            "transport_id" => $this->transport_id,
            "user_id" => $this->user_id,
            "organization_id" => $this->organization_id,
            "add_load_space" => $this->add_load_space,
            "road_back" => $this->road_back,
            "directly_road" => $this->directly_road,

            "status" => $this->status,
            "description" => $this->description,
            "order_unit_id" => $this->order_unit_id,
        ];
    }

    public static function fromArrayToObject(array $data) : self
    {
        return self::make(
            city_name_start: Arr::get($data, 'city_name_start'),
            city_name_end: Arr::get($data, 'city_name_end'),
            price_for_distance: Arr::get($data, 'price_for_distance'),
            transport_id: Arr::get($data, 'transport_id'),
            user_id: Arr::get($data, 'user_id'),
            organization_id: Arr::get($data, 'organization_id'),
            add_load_space: Arr::get($data, 'add_load_space', false),
            road_back: Arr::get($data, 'road_back', false),
            directly_road: Arr::get($data, 'directly_road', false),

            status: Arr::get($data, 'status', 'published'),
            description: Arr::get($data, 'description', null),
            order_unit_id: Arr::get($data, 'order_unit_id', null),
        );
    }
}
