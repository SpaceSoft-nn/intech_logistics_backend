<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPriceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $faker = Faker::create();

        return [

            "FTL" => [
                "value" => TypeLoadingTruckMethod::ftl->value,
                "price" => $faker->numberBetween(45000, 300000),
            ],

            "LTL" => [
                "value" => TypeLoadingTruckMethod::ltl->value,
                "price" => $faker->numberBetween(35000, 190000),
            ]

        ];
    }
}
