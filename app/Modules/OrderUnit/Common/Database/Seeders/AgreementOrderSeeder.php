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
        try {
            AgreementOrderAccept::factory()->count(3)->create();
        } catch (\Throwable $th) {

            $this->command->error('Пожалуйста перезапустите Seed, AgreementOrderSeeder - выбирается случайные OrderUnit, т.к они уникальны, они могу пересекаться.');
            throw new Exception();
        }
    }



}
