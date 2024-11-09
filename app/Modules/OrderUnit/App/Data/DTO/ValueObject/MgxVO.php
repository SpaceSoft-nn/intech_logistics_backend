<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

class MgxVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public readonly float $width,
        public ?float $length,
        public ?float $height,
        public ?float $weight,
    ) {}

    public static function make(

        float $width,
        ?float $length = null,
        ?float $height = null,
        ?float $weight = null,

    ) : self {

        return new self(
            length: $length,
            width: $width,
            height: $height,
            weight: $weight,
        );

    }


    public function toArray() : array
    {
        return [
            "length" => $this->length,
            "width" => $this->width,
            "height" => $this->height,
            "weight" => $this->weight,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        $length = Arr::get($data, "length");
        $width = Arr::get($data, "width");
        $height = Arr::get($data, "height");
        $weight = Arr::get($data, "weight");


        return new self(
            length: $length,
            width: $width,
            height: $height,
            weight: $weight,
        );
    }
}
