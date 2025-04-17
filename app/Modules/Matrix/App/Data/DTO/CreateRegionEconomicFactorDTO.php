<?php

namespace App\Modules\Matrix\App\Data\DTO;

use App\Modules\Matrix\App\Data\DTO\Base\BaseDTO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;

class CreateRegionEconomicFactorDTO extends BaseDTO
{
    public function __construct(

        public ?string $region_start_gar_id,
        public ?string $region_end_gar_id,
        public string $region_name_start,
        public string $region_name_end,

        public ?float $factor = 1,

        public string $price,
        public ?string $price_form_km,

        public ?TypeLoadingTruckMethod $type,
        public string $start_date,
        public string $end_date,


    ) { }

    public static function make(

        string $region_name_start,
        string $region_name_end,

        string $price,

        string $start_date,
        string $end_date,

        ?float $factor = 1,
        ?string $price_form_km = null,
        ?string $type = null,
        ?string $region_start_gar_id = null,
        ?string $region_end_gar_id = null,

    ) : self {

        return new self(

            region_start_gar_id: $region_start_gar_id,
            region_end_gar_id: $region_end_gar_id,
            region_name_start: $region_name_start,
            region_name_end: $region_name_end,

            factor: $factor,

            price: $price,
            price_form_km: $price_form_km,

            type: ($type) ? TypeLoadingTruckMethod::stringByCaseToObject($type) : null,

            start_date: $start_date,
            end_date: $end_date,

        );
    }

}
