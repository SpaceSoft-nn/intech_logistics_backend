<?php

namespace App\Modules\Matrix\App\Data\ValueObject;

use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Matrix\App\Data\DTO\Base\BaseDTO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;

class RegionEconomicFactorVO extends BaseDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $region_start_gar_id,
        public string $region_end_gar_id,
        public string $region_name_start,
        public string $region_name_end,

        public ?float $factor = 1,

        public string $price,
        public string $price_form_km,

        public TypeLoadingTruckMethod $type,
        public string $start_date,
        public string $end_date,

    ) { }

    public static function make(

        string $region_start_gar_id,
        string $region_end_gar_id,
        string $region_name_start,
        string $region_name_end,

        ?float $factor = 1,

        string $price,
        string $price_form_km,

        string $type,
        string $start_date,
        string $end_date,

    ) : self {

        return new self(

            region_start_gar_id: $region_start_gar_id,
            region_end_gar_id: $region_end_gar_id,
            region_name_start: $region_name_start,
            region_name_end: $region_name_end,
            factor: $factor,
            price: $price,
            price_form_km: $price_form_km,
            type: TypeLoadingTruckMethod::stringByCaseToObject($type),
            start_date: $start_date,
            end_date: $end_date,

        );
    }


    public function toArray() : array
    {
        return [
            "region_start_gar_id" => $this->region_start_gar_id,
            "region_end_gar_id" => $this->region_end_gar_id,
            "region_name_start" => $this->region_name_start,
            "region_name_end" => $this->region_name_end,
            "factor" => $this->factor,
            "price" => $this->price,
            "price_form_km" => $this->price_form_km,
            "type" => $this->type,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
        ];
    }

}
