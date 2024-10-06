<?php

namespace App\Modules\Adress\Common\Database\Seeders;

use App\Modules\Adress\Domain\Models\Adress;
use Cache;
use Illuminate\Database\Seeder;

class AdressSeeder extends Seeder
{
    public function run(): void
    {
        $this->createAdress();
    }

    private function createAdress()
    {
        {
            //Заказ 1
            $adressStart1 = Adress::factory()->create([
                "region" => 'Московский',
                "city" => 'Москва',
                "street" => 'Касимовская',
                "building" => "вл26",
                "postal_code" => "115404",
                "latitude" => 55.590465,
                "longitude" => 37.659326,
            ]);

            $adressEnd2 = Adress::factory()->create([
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
            $adressStart3 = Adress::factory()->create([
                "region" => 'Владимирская',
                "city" => 'Владимир',
                "street" => 'Юрьевская',
                "building" => "3/32",
                "postal_code" => "600005",
                "latitude" => 56.146342,
                "longitude" => 40.396502,
            ]);

            $adressEnd4 = Adress::factory()->create([
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
            $adressStart5 = Adress::factory()->create([
                "region" => 'Тамбовская',
                "city" => 'Тамбов',
                "street" => 'Октябрьская улица',
                "building" => "16Б",
                "postal_code" => "392024",
                "latitude" => 52.724737,
                "longitude" => 41.443210,
            ]);

            $adressEnd6 = Adress::factory()->create([
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
            $adressStart7 = Adress::factory()->create([
                "region" => 'Чувашская',
                "city" => 'Чебоксары',
                "street" => 'Чапаева',
                "building" => "41А",
                "postal_code" => "428003",
                "latitude" => 56.128822,
                "longitude" => 47.259352,
            ]);


            $adressEnd8 = Adress::factory()->create([
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
            $adressStart9 = Adress::factory()->create([
                "region" => 'Московская',
                "city" => 'Шатура',
                "street" => 'площадь Ленина',
                "building" => "1",
                "postal_code" => "140700",
                "latitude" => 55.577536,
                "longitude" => 39.542932,
            ]);


            $adressEnd10 = Adress::factory()->create([
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
            $adressStart11 = Adress::factory()->create([
                "region" => 'Нижегородская',
                "city" => 'Павлово',
                "street" => 'Суворова',
                "building" => "14",
                "postal_code" => "606108",
                "latitude" => 55.973945,
                "longitude" => 43.095643,
            ]);


            $adressEnd12 = Adress::factory()->create([
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
            $adressStart13 = Adress::factory()->create([
                "region" => 'Нижегородская',
                "city" => 'Семёнов',
                "street" => 'Бебеля',
                "building" => "9",
                "postal_code" => "606650",
                "latitude" => 56.793602,
                "longitude" => 44.490915,
            ]);


            $adressEnd14 = Adress::factory()->create([
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
            $adressStart15 = Adress::factory()->create([
                "region" => 'Воронежская',
                "city" => 'Воронеж',
                "street" => 'Кропоткина',
                "building" => "9А",
                "postal_code" => "394030",
                "latitude" => 51.671087,
                "longitude" => 39.183102,
            ]);


            $adressEnd16 = Adress::factory()->create([
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
            $adressStart17 = Adress::factory()->create([
                "region" => 'Татарстан',
                "city" => 'Казань',
                "street" => 'Аделя Кутуя',
                "building" => "65",
                "postal_code" => null,
                "latitude" => 55.786622,
                "longitude" => 49.182564,
            ]);

            $adressEnd18 = Adress::factory()->create([
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
            $adressStart19 = Adress::factory()->create([
                "region" => 'Челябинская',
                "city" => 'Челябинск',
                "street" => 'Разина',
                "building" => "1В",
                "postal_code" => 454048,
                "latitude" => 55.136355,
                "longitude" => 61.405617,
            ]);


            $adressEnd20 = Adress::factory()->create([
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
            $adressStart21 = Adress::factory()->create([
                "region" => 'Смоленская',
                "city" => 'Ярцево',
                "street" => 'Школьная улица',
                "building" => "8",
                "postal_code" => 215800,
                "latitude" => 55.069407,
                "longitude" => 32.691786,
            ]);

            $adressEnd22 = Adress::factory()->create([
                "region" => 'Татарстан',
                "city" => 'Менделеевск',
                "street" => 'Советская улица',
                "building" => "8",
                "postal_code" => 423650,
                "latitude" => 55.893157,
                "longitude" => 52.309420,
            ]);
        }

        $cacheArray = [
            1 => $adressStart1,
            2 => $adressEnd2,
            3 => $adressStart3,
            4 => $adressEnd4,
            5 => $adressStart5,
            6 => $adressEnd6,
            7 => $adressStart7,
            8 => $adressEnd8,
            9 => $adressStart9,
            10 => $adressEnd10,
            11 => $adressStart11,
            12 => $adressEnd12,
            13 => $adressStart13,
            14 => $adressEnd14,
            15 => $adressStart15,
            16 => $adressEnd16,
            17 => $adressStart17,
            18 => $adressEnd18,
            19 => $adressStart19,
            20 => $adressEnd20,
            21 => $adressStart21,
            22 => $adressEnd22,
        ];

        Cache::put('adress_seeder', $cacheArray, 5);
    }

}
