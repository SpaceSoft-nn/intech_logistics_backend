<?php

namespace App\Modules\IndividualPeople\Common\Database\Seeders;

use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople;
use Faker\Generator;
use Illuminate\Database\Seeder;


class StorekeeperPeopleSeed extends Seeder
{

    public function run(): void
    {
        $this->createAgreementOrder();
    }

    private function createAgreementOrder()
    {

        StorekeeperPeople::factory()->count(4)->create();
    }



}
