<?php

namespace App\Modules\Address\Common\Database\Seeders;

use App\Modules\Address\Domain\Models\Address;
use Cache;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $this->createAddress();
    }

    private function createAddress()
    {
        {
            //Заказ 1
            $AddressStart1 = Address::factory()->create([
                "region" => 'Московский',
                "city" => 'Москва',
                "street" => 'Касимовская',
                "building" => "вл26",
                "postal_code" => "115404",
                "latitude" => 55.590465,
                "longitude" => 37.659326,
            ]);

            $AddressEnd2 = Address::factory()->create([
                "region" => 'Татарстан',
                "city" => 'Казань',
                "street" => 'Юлиуса Фучика',
                "building" => "88А",
                "postal_code" => "420141",
                "latitude" => 55.762814,
                "longitude" => 49.232546,
            ]);
        }

        {
            //Заказ 2
            $AddressStart3 = Address::factory()->create([
                "region" => 'Владимирская',
                "city" => 'Владимир',
                "street" => 'Юрьевская',
                "building" => "3/32",
                "postal_code" => "600005",
                "latitude" => 56.146342,
                "longitude" => 40.396502,
            ]);

            $AddressEnd4 = Address::factory()->create([
                "region" => 'Костромская',
                "city" => 'Шарья',
                "street" => 'Ленина',
                "building" => "13",
                "postal_code" => "420141",
                "latitude" => 58.371312,
                "longitude" => 45.518956,
            ]);
        }

        {
            //Заказ 3
            $AddressStart5 = Address::factory()->create([
                "region" => 'Тамбовская',
                "city" => 'Тамбов',
                "street" => 'Октябрьская улица',
                "building" => "16Б",
                "postal_code" => "392024",
                "latitude" => 52.724737,
                "longitude" => 41.443210,
            ]);

            $AddressEnd6 = Address::factory()->create([
                "region" => 'Самарская',
                "city" => 'Самара',
                "street" => 'проспект Юных Пионеров',
                "building" => "34Б",
                "postal_code" => "443063",
                "latitude" => 53.219236,
                "longitude" => 50.229182,
            ]);
        }

        {
            //Заказ 4
            $AddressStart7 = Address::factory()->create([
                "region" => 'Чувашская',
                "city" => 'Чебоксары',
                "street" => 'Чапаева',
                "building" => "41А",
                "postal_code" => "428003",
                "latitude" => 56.128822,
                "longitude" => 47.259352,
            ]);


            $AddressEnd8 = Address::factory()->create([
                "region" => 'Пермская',
                "city" => 'Пермь',
                "street" => 'Попова',
                "building" => "21",
                "postal_code" => "614068",
                "latitude" => 56.226362,
                "longitude" => 58.007322,
            ]);
        }

        {
            //Заказ 5
            $AddressStart9 = Address::factory()->create([
                "region" => 'Московская',
                "city" => 'Шатура',
                "street" => 'площадь Ленина',
                "building" => "1",
                "postal_code" => "140700",
                "latitude" => 55.577536,
                "longitude" => 39.542932,
            ]);


            $AddressEnd10 = Address::factory()->create([
                "region" => 'Нижегородская',
                "city" => 'Нижний Новгород',
                "street" => 'площадь Свободы',
                "building" => "1В",
                "postal_code" => "603006",
                "latitude" => 56.318606,
                "longitude" => 44.012787,
            ]);
        }

        {
            //Заказ 6
            $AddressStart11 = Address::factory()->create([
                "region" => 'Нижегородская',
                "city" => 'Павлово',
                "street" => 'Суворова',
                "building" => "14",
                "postal_code" => "606108",
                "latitude" => 55.973945,
                "longitude" => 43.095643,
            ]);


            $AddressEnd12 = Address::factory()->create([
                "region" => 'Нижегородская',
                "city" => 'Кстово',
                "street" => 'Спортивный переулок',
                "building" => "3",
                "postal_code" => "607650",
                "latitude" => 56.151708,
                "longitude" => 44.204047,
            ]);
        }

        {
            //Заказ 7
            $AddressStart13 = Address::factory()->create([
                "region" => 'Нижегородская',
                "city" => 'Семёнов',
                "street" => 'Бебеля',
                "building" => "9",
                "postal_code" => "606650",
                "latitude" => 56.793602,
                "longitude" => 44.490915,
            ]);


            $AddressEnd14 = Address::factory()->create([
                "region" => 'Татарстан',
                "city" => 'село Осиново',
                "street" => 'Светлая',
                "building" => "10",
                "postal_code" => "422527",
                "latitude" => 55.875642,
                "longitude" => 48.891753,
            ]);
        }

        {
            //Заказ 8
            $AddressStart15 = Address::factory()->create([
                "region" => 'Воронежская',
                "city" => 'Воронеж',
                "street" => 'Кропоткина',
                "building" => "9А",
                "postal_code" => "394030",
                "latitude" => 51.671087,
                "longitude" => 39.183102,
            ]);


            $AddressEnd16 = Address::factory()->create([
                "region" => 'Краснодарский',
                "city" => 'Краснодар',
                "street" => 'Зиповская',
                "building" => "5ВлитЦ",
                "postal_code" => null,
                "latitude" => 45.062210,
                "longitude" => 38.990800,
            ]);
        }

        {
            //Заказ 9
            $AddressStart17 = Address::factory()->create([
                "region" => 'Татарстан',
                "city" => 'Казань',
                "street" => 'Аделя Кутуя',
                "building" => "65",
                "postal_code" => null,
                "latitude" => 55.786622,
                "longitude" => 49.182564,
            ]);

            $AddressEnd18 = Address::factory()->create([
                "region" => 'Самарская',
                "city" => 'Самара',
                "street" => 'Самарская',
                "building" => "205А",
                "postal_code" => 443001,
                "latitude" => 53.200539,
                "longitude" => 50.115150,
            ]);
        }

        {
            //Заказ 10
            $AddressStart19 = Address::factory()->create([
                "region" => 'Челябинская',
                "city" => 'Челябинск',
                "street" => 'Разина',
                "building" => "1В",
                "postal_code" => 454048,
                "latitude" => 55.136355,
                "longitude" => 61.405617,
            ]);


            $AddressEnd20 = Address::factory()->create([
                "region" => 'Тюменская',
                "city" => 'Сургут',
                "street" => 'Домостроителей',
                "building" => "19",
                "postal_code" => 628404,
                "latitude" => 61.276972,
                "longitude" => 73.391793,
            ]);
        }

        {

            //Заказ 11
            $AddressStart21 = Address::factory()->create([
                "region" => 'Смоленская',
                "city" => 'Ярцево',
                "street" => 'Школьная улица',
                "building" => "8",
                "postal_code" => 215800,
                "latitude" => 55.069407,
                "longitude" => 32.691786,
            ]);

            $AddressEnd22 = Address::factory()->create([
                "region" => 'Татарстан',
                "city" => 'Менделеевск',
                "street" => 'Советская улица',
                "building" => "8",
                "postal_code" => 423650,
                "latitude" => 55.893157,
                "longitude" => 52.309420,
            ]);
        }

        {

            //Заказ 12
            $AddressStart23 = Address::factory()->create([
                "region" => 'Владимирская',
                "city" => 'Владимир',
                "street" => 'Федосеева',
                "building" => "5",
                "postal_code" => 600000,
                "latitude" =>  56.127201,
                "longitude" => 40.385479,
            ]);

            $AddressEnd24 = Address::factory()->create([
                "region" => 'Московская область',
                "city" => 'Борисово',
                "street" => 'Нагорная',
                "building" => "143216",
                "postal_code" => 423650,
                "latitude" => 55.420362,
                "longitude" => 36.054782,
            ]);
        }

        $cacheArray = [
            1 => $AddressStart1,
            2 => $AddressEnd2,
            3 => $AddressStart3,
            4 => $AddressEnd4,
            5 => $AddressStart5,
            6 => $AddressEnd6,
            7 => $AddressStart7,
            8 => $AddressEnd8,
            9 => $AddressStart9,
            10 => $AddressEnd10,
            11 => $AddressStart11,
            12 => $AddressEnd12,
            13 => $AddressStart13,
            14 => $AddressEnd14,
            15 => $AddressStart15,
            16 => $AddressEnd16,
            17 => $AddressStart17,
            18 => $AddressEnd18,
            19 => $AddressStart19,
            20 => $AddressEnd20,
            21 => $AddressStart21,
            22 => $AddressEnd22,
            23 => $AddressStart23,
            24 => $AddressEnd24,
        ];

        Cache::put('Address_seeder', $cacheArray, 5);
    }

}
