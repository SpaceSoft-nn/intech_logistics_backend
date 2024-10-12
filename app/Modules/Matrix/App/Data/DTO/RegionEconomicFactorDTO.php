<?php

namespace App\Modules\Matrix\App\Data\DTO;

use App\Modules\Matrix\App\Data\DTO\Base\BaseDTO;
use Illuminate\Contracts\Support\Arrayable;

class RegionEconomicFactorDTO extends BaseDTO implements Arrayable
{
    public function __construct(
        public string $region_start_gar_id,
        public string $region_end_gar_id,
        public string $region_name_start,
        public string $region_name_end,
        public float $factor,
        public float $price, //TODO здесь нужно делать свой каст на работу с деньгами
    ) { }

    public static function make(

        string $region_start_gar_id,
        string $region_end_gar_id,
        string $region_name_start,
        string $region_name_end,
        float $factor,
        float $price,

    ) : self {

        return new self(
            region_start_gar_id: $region_start_gar_id,
            region_end_gar_id: $region_end_gar_id,
            region_name_start: $region_name_start,
            region_name_end: $region_name_end,
            factor: $factor,
            price: $price,
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
            "price" => $this->price ?? null,
        ];
    }
}
