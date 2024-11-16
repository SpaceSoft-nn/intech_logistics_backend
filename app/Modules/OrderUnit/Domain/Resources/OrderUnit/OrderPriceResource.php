<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPriceResource extends JsonResource
{

    protected $distance;

    public function __construct($resource, $distance)
    {
        //получаем idOrderUnit - для проверки и получение таблицы pivot при связях многие ко многим
        $this->distance = $distance;

        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        $faker = Faker::create();

        $price1 = $faker->numberBetween(45000, 300000);
        $price2 = $faker->numberBetween(45000, 300000);


        return [

            "FTL" => [
                "load_type" => TypeLoadingTruckMethod::ftl->value,
                "price_km" =>  $price1 / $this->distance,
                "price" => $price1,
            ],

            "LTL" => [
                "load_type" => TypeLoadingTruckMethod::ltl->value,
                "price_km" => $price2 / $this->distance,
                "price" => $price2,
            ]

        ];
    }
}
