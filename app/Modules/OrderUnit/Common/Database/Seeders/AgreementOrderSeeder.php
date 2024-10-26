<?php

namespace App\Modules\OrderUnit\Common\Database\Seeders;

use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use Exception;
use Faker\Generator;
use Illuminate\Database\Seeder;


class AgreementOrderSeeder extends Seeder
{

    public function __construct(
        private Generator $faker,
    ) { }



    public function run(): void
    {
        $this->createAgreementOrder();
    }

    private function createAgreementOrder()
    {

        AgreementOrderAccept::factory()->count(1)->create();
        // try {


        //     AgreementOrderAccept::factory()->count(1)->create();


        // } catch (\Throwable $th) {

        //     //Из за того что OrderUnit при создании Factory выбирается случаным образом, они могут перескачаться, т.к у нас в таблицах должны быть уникальные значение OrderUnit без повторений, вылетает ошибка
        //     $this->command->error('Пожалуйста перезапустите Seed, AgreementOrderSeeder - выбирается случайные OrderUnit, т.к они уникальны, они могу пересекаться.');
        //     throw new Exception();
        // }
    }



}
