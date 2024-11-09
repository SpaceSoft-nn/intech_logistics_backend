<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class CargoGoodVO implements Arrayable
{

    public function __construct(

        public readonly float $length,
        public readonly float $width,
        public readonly float $height,
        public readonly float $weight,
        public readonly ?string $cargo_good_id,

    ) {}

    public static function make(

        float $length,
        float $width,
        float $height,
        float $weight,
        string $cargo_good_id = null,


    ) : self {

        return new self(

            length: $length,
            width: $width,
            height: $height,
            weight: $weight,
            cargo_good_id: $cargo_good_id,

        );

    }

    /**
     * VO - Должен сохранять иммутабельность, поэтому делаем новый объект с заполненным полям
     * @return self
     */
    public function withCargoGoodId(string $cargo_good_id) : self
    {
        return new self (
            length: $this->length,
            width: $this->width,
            height: $this->height,
            weight: $this->weight,
            cargo_good_id: $cargo_good_id,
        );
    }


    public function toArray() : array
    {
        return [
            "product_type" => $this->product_type,
            "cargo_units_count" => $this->cargo_units_count,
            "body_bolume" => $this->body_bolume,
            "name_value" => $this->name_value,
            "description" => $this->description,
            "cargo_good_id" => $this->cargo_good_id,
        ];
    }
}
