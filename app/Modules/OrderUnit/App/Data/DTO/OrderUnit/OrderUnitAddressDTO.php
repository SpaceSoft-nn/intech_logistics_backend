<?php

namespace App\Modules\OrderUnit\App\Data\DTO\OrderUnit;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\MainAddress\MainAddressVectorVO;
use Arr;

final readonly class OrderUnitAddressDTO
{

    /**
     * @param MainAddressVectorVO $mainAddressVectorVO
     * @param ?array $addressArray массив адрессов - указанные при
    */
    public function __construct(

        public MainAddressVectorVO $mainAddressVectorVO,
        public ?array $addressArray,

    ) { }

    public static function make(

        MainAddressVectorVO $mainAddressVectorVO,
        ?array $addressArray = null,

    ) : self {

        return new self(
            mainAddressVectorVO: $mainAddressVectorVO,
            addressArray: $addressArray,
        );

    }

    public static function fromArrayToObject(array $data): self
    {
        $start_address_id = Arr::get($data, "start_address_id");
        $end_address_id = Arr::get($data, "end_address_id");

        $start_date_delivery = Arr::get($data, "start_date_delivery");
        $end_date_delivery = Arr::get($data, "end_date_delivery");

        $address_array = Arr::get($data, "address_array", null);

        return static::make(
            mainAddressVectorVO: mainAddressVectorVO::make(
                start_address_id: $start_address_id,
                end_address_id: $end_address_id,
                start_date_delivery: $start_date_delivery,
                end_date_delivery: $end_date_delivery,
            ),
            addressArray: $address_array,
        );
    }

    //переводим из модели InvoiceOrderCustomer - которое присылаем как string, в объект OrderUnitVO
    public static function fromArrayInvoiceOrderCustomerToObject(array $data): self
    {

        $start_address_id = Arr::get($data, "start_address_id");
        $end_address_id = Arr::get($data, "end_address_id");

        $start_date_delivery = Arr::get($data, "start_date");
        $end_date_delivery = Arr::get($data, "end_date");


        $address_array = Arr::get($data, "address_array", null);

        return static::make(
            mainAddressVectorVO: mainAddressVectorVO::make(
                start_address_id: $start_address_id,
                end_address_id: $end_address_id,
                start_date_delivery: $start_date_delivery,
                end_date_delivery: $end_date_delivery,
            ),
            addressArray: $address_array,
        );
    }



}
