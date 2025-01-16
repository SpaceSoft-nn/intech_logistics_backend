<?php

namespace App\Modules\IndividualPeople\Common\Database\Seeders;

use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople;
use Faker\Generator;
use Illuminate\Database\Seeder;


class StorekeeperPeopleSeed extends Seeder
{

    public function run(): void
    {
        $this->createAgreementOrder();
        $this->createAgreementOrder();
        $this->createAgreementOrder();
        $this->createAgreementOrder();
    }

    private function createAgreementOrder()
    {
        //Создаём IndividualPeople и запись StorekeeperPeople и связываем полиморфной связью
        /** @var IndividualPeople */
        $individualPeople = IndividualPeople::factory()
        ->for(
            StorekeeperPeople::factory(), 'individualable'
        )
        ->create();
    }



}
