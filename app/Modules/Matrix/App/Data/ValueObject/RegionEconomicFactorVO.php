<?php

namespace App\Modules\Matrix\App\Data\ValueObject;

use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;

final readonly class RegionEconomicFactorVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public ?string $region_start_gar_id,
        public ?string $region_end_gar_id,
        public string $region_name_start,
        public string $region_name_end,

        public ?float $factor = 1,
        public ?int $distance = 0,

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

        ?string $type = null,
        ?string $price_form_km = null,
        ?string $region_start_gar_id = null,
        ?string $region_end_gar_id = null,
        ?float $factor = 1,
        ?int $distance = 0,

    ) : self {

        return new self(

            region_start_gar_id: $region_start_gar_id,
            region_end_gar_id: $region_end_gar_id,
            region_name_start: $region_name_start,
            region_name_end: $region_name_end,
            distance: $distance,
            factor: $factor,
            price: $price,
            price_form_km: $price_form_km,
            type: ($type) ? TypeLoadingTruckMethod::stringByCaseToObject($type) : null,
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
            "distance" => $this->distance,
            "factor" => $this->factor,
            "price" => $this->price,
            "price_form_km" => $this->price_form_km,
            "type" => $this->type,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
        ];
    }

}
