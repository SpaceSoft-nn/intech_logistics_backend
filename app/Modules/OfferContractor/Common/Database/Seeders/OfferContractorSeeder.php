<?php

namespace App\Modules\OfferContractor\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;


class OfferContractorSeeder extends Seeder
{

    public function run(): void
    {
        $this->createOfferContractor();
    }

    private function createOfferContractor()
    {
        OfferContractor::factory()->count(5)->create();
    }

}
