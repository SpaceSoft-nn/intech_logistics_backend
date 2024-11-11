<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

final readonly class MgxVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public float $width,
        public float $length,
        public float $height,
        public string $cargo_good_id,
        public ?float $weight, //вес кг
    ) {}

    public static function make(

        float $length,
        float $height,
        float $width,
        string $cargo_good_id,
        ?float $weight = null,

    ) : self {

        return new self(
            length: $length,
            width: $width,
            height: $height,
            cargo_good_id: $cargo_good_id,
            weight: $weight,
        );

    }


    public function toArray() : array
    {
        return [
            "length" => $this->length,
            "width" => $this->width,
            "height" => $this->height,
            "cargo_good_id" => $this->cargo_good_id,
            "weight" => $this->weight,
        ];
    }

}
