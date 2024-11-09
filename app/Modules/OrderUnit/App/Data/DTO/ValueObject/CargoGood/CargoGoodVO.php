<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

class CargoGoodVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public readonly string $product_type,
        public readonly int $cargo_units_count,
        public readonly float $body_volume,
        public  ?string $name_value,
        public  ?string $description,

    ) {}

    public static function make(

        string $product_type,
        int $cargo_units_count,
        float $body_volume,
        ?string $name_value = null,
        ?string $description = null,

    ) : self {

        return new self(

            product_type: $product_type,
            cargo_units_count: $cargo_units_count,
            body_volume: $body_volume,
            name_value: $name_value,
            description: $description,

        );

    }


    public function toArray() : array
    {
        return [
            "product_type" => $this->product_type,
            "cargo_units_count" => $this->cargo_units_count,
            "body_volume" => $this->body_volume,
            "name_value" => $this->name_value,
            "description" => $this->description,
        ];
    }

    /**
     * @param array $data
     *
     * @return ?CargoGoodVO[]
     */
    public static function fromArrayToObject(array $data): ?array
    {

        if(empty($data['goods_array'])) { return null; }

        //получаем массив goods_array
        $datas = $data['goods_array'];
        $array = [];

        foreach ($datas as $data) {

            $product_type = Arr::get($data, "product_type");
            $cargo_units_count = Arr::get($data, "cargo_units_count");
            $body_volume = Arr::get($data, "body_volume");
            $name_value = Arr::get($data, "name_value", null);
            $description = Arr::get($data, "description", null);

            $array[] = new self(
                product_type: $product_type,
                cargo_units_count: $cargo_units_count,
                body_volume: $body_volume,
                name_value: $name_value,
                description: $description,
            );
        }

        return $array;
    }
}
