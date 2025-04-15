<?php

namespace App\Modules\OrderUnit\Domain\Resources\OrderUnit;

use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;

class OrderPriceResource extends JsonResource
{

    protected $distance;
    protected ?float $price_bysiness;

    public function __construct($resource, $distance, ?float $price_bysiness = null)
    {
        //получаем idOrderUnit - для проверки и получение таблицы pivot при связях многие ко многим
        $this->distance = $distance;
        $this->price_bysiness = $price_bysiness;

        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        $faker = Faker::create();

        $price1 = $faker->numberBetween(45000, 300000);
        $price2 = $faker->numberBetween(45000, 300000);

        $epsilon = 0.00001; // задаем порог сравнения
        // если мы будем сравнивать с 0 float, могут быть проблемы
        if (abs($this->price_bysiness) < $epsilon) {
            $this->price_bysiness = 0;
            echo "Значение близко к нулю";
        } 

        #TODO в load_type надо возвращать имя кейса
        return [

            [
                'name' => 'ftl',
                "load_type" => TypeLoadingTruckMethod::objectValueToStringCaseName(TypeLoadingTruckMethod::ftl),
                "price_km" =>  $price1 / $this->distance,
                "price" => $price1,
            ],

            [
                'name' => 'ltl',
                "load_type" => TypeLoadingTruckMethod::objectValueToStringCaseName(TypeLoadingTruckMethod::ltl),
                "price_km" => $price2 / $this->distance,
                "price" => $price2,
            ],

            [
                'name' => TypeLoadingTruckMethod::more_load->value,
                "load_type" => TypeLoadingTruckMethod::objectValueToStringCaseName(TypeLoadingTruckMethod::more_load),
                "price_km" => $price2 / $this->distance,
                "price" => $price2,
            ],

            [
                'name' => TypeLoadingTruckMethod::business_lines->value,
                "load_type" => TypeLoadingTruckMethod::objectValueToStringCaseName(TypeLoadingTruckMethod::business_lines),
                "price_km" =>  $this->price_bysiness / $this->distance,
                "price" => $this->price_bysiness,
            ],

        ];
    }
}
