<?php

namespace App\Modules\Matrix\App\Data\DTO;

use App\Modules\Matrix\App\Data\DTO\Base\BaseDTO;
use Illuminate\Contracts\Support\Arrayable;

class MatrixDistanceDTO extends BaseDTO implements Arrayable
{
    public function __construct(
        public string $city_start_gar_id,
        public string $city_end_gar_id,
        public string $city_name_start,
        public string $city_name_end,
        public float $distance,
    ) { }

    public static function make(

        string $city_start_gar_id,
        string $city_end_gar_id,
        string $city_name_start,
        string $city_name_end,
        float $distance,

    ) : self {

        return new self(
            city_start_gar_id: $city_start_gar_id,
            city_end_gar_id: $city_end_gar_id,
            city_name_start: $city_name_start,
            city_name_end: $city_name_end,
            distance: $distance,
        );
    }

    public function toArray() : array
    {
        return [
            "city_start_gar_id" => $this->city_end_gar_id,
            "city_end_gar_id" => $this->city_end_gar_id,
            "city_name_start" => $this->city_name_start,
            "city_name_end" => $this->city_name_end,
            "distance" => $this->distance,
        ];
    }

}
