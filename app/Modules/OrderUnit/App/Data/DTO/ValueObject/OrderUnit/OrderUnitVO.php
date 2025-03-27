<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit;

use Arr;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;

final readonly class OrderUnitVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        //date
        public string $end_date_order,
        public ?string $exemplary_date_start, // примерная дата отправки

        public ?float $body_volume,
        public string $order_total,

        //enum
        public TypeTransportWeight $type_transport_weight,
        public TypeLoadingTruckMethod $type_load_truck,
        public ?StatusOrderUnitEnum $order_status,

        public ?string $description,

        public ?string $organization_id,
        public ?string $user_id,
        public ?string $contractor_id,
        public ?string $transport_id,

        //bool
        public ?bool $add_load_space,
        public ?bool $change_price,
        public ?bool $change_time,
        public ?string $lot_tender_id, // Если заказ создаётся по бизнес-логики Тендера
        public ?string $offer_contractor_id, // Логика при предложении перевозчика

    ) {}

    public static function make(

        string $order_total,
        string $end_date_order,

        string $type_load_truck,
        string $type_transport_weight,

        bool $add_load_space,

        ?string $exemplary_date_start = null,
        ?float $body_volume = null,
        ?string $description = null,
        ?string $order_status = null,

        ?string $user_id = null,
        ?string $contractor_id = null,
        ?string $organization_id = null,
        ?string $transport_id = null,

        ?bool $change_price = null,
        ?bool $change_time = null,
        ?string $lot_tender_id = null,
        ?string $offer_contractor_id = null,

    ) : self {

        return new self(


            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,

            //date
            end_date_order: $end_date_order,
            exemplary_date_start: $exemplary_date_start,
            //
            type_load_truck: TypeLoadingTruckMethod::stringByCaseToObject($type_load_truck),
            type_transport_weight: TypeTransportWeight::stringByCaseToObject($type_transport_weight),
            order_status: StatusOrderUnitEnum::stringByCaseToObject($order_status),

            user_id: $user_id,
            contractor_id: $contractor_id,
            organization_id: $organization_id,
            transport_id: $transport_id,

            add_load_space: $add_load_space,
            change_price: $change_price,
            change_time: $change_time,
            lot_tender_id: $lot_tender_id,
            offer_contractor_id: $offer_contractor_id,

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

            //date
            end_date_order: $this->end_date_order,
            exemplary_date_start: $this->exemplary_date_start,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $this->contractor_id,
            organization_id: $this->organization_id,
            transport_id: $this->transport_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
            offer_contractor_id: $this->offer_contractor_id,
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

            //date
            end_date_order: $this->end_date_order,
            exemplary_date_start: $this->exemplary_date_start,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $contractor_id,
            organization_id: $this->organization_id,
            transport_id: $this->transport_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
            offer_contractor_id: $this->offer_contractor_id,
        );
    }

    /**
     * @param StatusOrderUnitEnum $orderStatus
     *
     * @return self
     */
    public function setOrderStatus(StatusOrderUnitEnum $orderStatus) : self
    {
        return $this::make(
            body_volume: $this->body_volume,
            order_total: $this->order_total,
            description: $this->description,

            //date
            end_date_order: $this->end_date_order,
            exemplary_date_start: $this->exemplary_date_start,

            type_load_truck: $this->type_load_truck->value,
            type_transport_weight: $this->type_transport_weight->value,
            order_status: $orderStatus->value,

            user_id: $this->user_id,
            contractor_id: $this->contractor_id,
            organization_id: $this->organization_id,
            transport_id: $this->transport_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
            offer_contractor_id: $this->offer_contractor_id,
        );
    }


    public function setOrganizationId(string $organization_id) : self
    {
        return new self (
            body_volume: $this->body_volume,
            order_total: $this->order_total,
            description: $this->description,

            //date
            end_date_order: $this->end_date_order,
            exemplary_date_start: $this->exemplary_date_start,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $this->contractor_id,
            organization_id: $organization_id,
            transport_id: $this->transport_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
            offer_contractor_id: $this->offer_contractor_id,
        );
    }

    public function setTransportId(string $transport_id) : self
    {
        return new self (
            body_volume: $this->body_volume,
            order_total: $this->order_total,
            description: $this->description,

            //date
            end_date_order: $this->end_date_order,
            exemplary_date_start: $this->exemplary_date_start,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $this->contractor_id,
            organization_id: $this->organization_id,
            transport_id: $transport_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
            offer_contractor_id: $this->offer_contractor_id,
        );
    }

    public function setOfferContractorId(string $offerContractorId) : self
    {
        return new self (
            body_volume: $this->body_volume,
            order_total: $this->order_total,
            description: $this->description,

            //date
            end_date_order: $this->end_date_order,
            exemplary_date_start: $this->exemplary_date_start,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $this->contractor_id,
            organization_id: $this->organization_id,
            transport_id: $this->transport_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $this->lot_tender_id,
            offer_contractor_id: $offerContractorId,
        );
    }

    public function setLotTenderId(string $lotTenderId) : self
    {
        return new self (
            body_volume: $this->body_volume,
            order_total: $this->order_total,
            description: $this->description,

            //date
            end_date_order: $this->end_date_order,
            exemplary_date_start: $this->exemplary_date_start,

            type_load_truck: $this->type_load_truck,
            type_transport_weight: $this->type_transport_weight,
            order_status: $this->order_status,

            user_id: $this->user_id,
            contractor_id: $this->contractor_id,
            organization_id: $this->organization_id,
            transport_id: $this->transport_id,

            add_load_space: $this->add_load_space,
            change_price: $this->change_price,
            change_time: $this->change_time,
            lot_tender_id: $lotTenderId,
            offer_contractor_id: $this->offer_contractor_id,
        );
    }

    public function toArray() : array
    {
        return [

            "end_date_order" => $this->end_date_order,
            "exemplary_date_start" => $this->exemplary_date_start,

            "body_volume" => $this->body_volume,
            "order_total" => $this->order_total,
            "description" => $this->description,

            "type_load_truck" => $this->type_load_truck?->value,
            "type_transport_weight" => $this->type_transport_weight?->value,
            "order_status" => $this->order_status?->value,

            "user_id" => $this->user_id,
            "contractor_id" => $this->contractor_id,
            "organization_id" => $this->organization_id,
            "transport_id" => $this->transport_id,

            //служебные
            "add_load_space" => $this->add_load_space,
            "change_price" => $this->change_price,
            "change_time" => $this->change_time,
            "lot_tender_id" => $this->lot_tender_id,
            "offer_contractor_id" => $this->offer_contractor_id,

        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        $end_date_order = Arr::get($data, "end_date_order");
        $exemplary_date_start = Arr::get($data, "exemplary_date_start" , null);


        $body_volume = Arr::get($data, "body_volume", null);
        $order_total = Arr::get($data, "order_total");
        $description = Arr::get($data, "description", null);

        $type_load_truck = Arr::get($data, "type_load_truck");
        $type_transport_weight = Arr::get($data, "type_transport_weight");
        $order_status = Arr::get($data, "order_status", null);

        $user_id = Arr::get($data, "user_id", null);
        $contractor_id = Arr::get($data, "contractor_id", null);
        $organization_id = Arr::get($data, "organization_id", null);
        $transport_id = Arr::get($data, "transport_id" , null);


        $change_price = Arr::get($data, "change_price", null);
        $change_time = Arr::get($data, "change_time", null);
        $lot_tender_id = Arr::get($data, "lot_tender_id" , null);
        $offer_contractor_id = Arr::get($data, "offer_contractor_id" , null);

        return static::make(

            end_date_order: $end_date_order,
            exemplary_date_start: $exemplary_date_start,

            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,

            type_load_truck: $type_load_truck,
            type_transport_weight: $type_transport_weight,
            order_status: $order_status,

            user_id: $user_id,
            contractor_id: $contractor_id,
            organization_id: $organization_id,
            transport_id: $transport_id,

            add_load_space: self::filterEnumTypeLoad($type_load_truck),
            change_price: $change_price,
            change_time: $change_time,
            lot_tender_id: $lot_tender_id,
            offer_contractor_id: $offer_contractor_id,
        );
    }

    //переводим из модели InvoiceOrderCustomer - которое присылаем как string, в объект OrderUnitVO
    public static function fromArrayInvoiceOrderCustomerToObject(array $data): self
    {

        $end_date_order = Arr::get($data, "end_date");
        $exemplary_date_start = Arr::get($data, "start_date" , null);

        $body_volume = Arr::get($data, "body_volume", null);
        $order_total = Arr::get($data, "order_total");
        $description = Arr::get($data, "description", null);

        $type_load_truck = TypeLoadingTruckMethod::stringValueCaseToObject(Arr::get($data, "type_load_truck"));
        $type_transport_weight = TypeTransportWeight::stringValueCaseToObject(Arr::get($data, "type_transport_weight"));

        $order_status = Arr::get($data, "order_status", null);

        $user_id = Arr::get($data, "user_id", null);
        $contractor_id = Arr::get($data, "contractor_id", null);
        $organization_id = Arr::get($data, "organization_id", null);
        $transport_id = Arr::get($data, "transport_id", null);

        $change_price = Arr::get($data, "change_price", null);
        $change_time = Arr::get($data, "change_time", null);
        $lot_tender_id = Arr::get($data, "lot_tender_id" , null);
        $offer_contractor_id = Arr::get($data, "offer_contractor_id" , null);



        return static::make(

            end_date_order: $end_date_order,
            exemplary_date_start: $exemplary_date_start,

            body_volume: $body_volume,
            order_total: $order_total,
            description: $description,

            type_load_truck: $type_load_truck->name,
            type_transport_weight: $type_transport_weight->name,
            order_status: $order_status,

            user_id: $user_id,
            contractor_id: $contractor_id,
            organization_id: $organization_id,
            transport_id: $transport_id,

            add_load_space: self::filterEnumTypeLoad($type_load_truck->name),
            change_price: $change_price,
            change_time: $change_time,
            lot_tender_id: $lot_tender_id,
            offer_contractor_id: $offer_contractor_id,
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
