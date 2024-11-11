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
        public ?float $weight, //вес кг
        public ?string $cargo_good_id,
    ) {}

    public function withCargoGoodId(string $cargo_good_id) : self
    {
        return new self (
            width: $this->width,
            length: $this->length,
            height: $this->height,
            cargo_good_id: $cargo_good_id,
            weight: $this->weight,
        );
    }

    public static function make(

        float $length,
        float $height,
        float $width,
        ?float $weight = null,
        ?string $cargo_good_id = null,

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

    public static function fromArrayToObject(array $data): self
    {
        $length = Arr::get($data, "length");
        $width = Arr::get($data, "width");
        $height = Arr::get($data, "height");
        $cargo_good_id = Arr::get($data, "cargo_good_id", null);
        $weight = Arr::get($data, "weight", null);


        return new self(
            length: $length,
            width: $width,
            height: $height,
            cargo_good_id: $cargo_good_id,
            weight: $weight,
        );
    }

}
