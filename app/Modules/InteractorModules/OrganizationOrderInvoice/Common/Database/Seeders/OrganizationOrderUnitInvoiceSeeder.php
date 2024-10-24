<?php

namespace App\Modules\OrderUnit\Common\Database\Seeders;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use Illuminate\Database\Seeder;


class AgreementOrderSeeder extends Seeder
{

    public function run(): void
    {
        $this->createOrganizationOrderUnitInvoice();
    }

    private function createOrganizationOrderUnitInvoice()
    {
        OrganizationOrderUnitInvoice::factory()->create();
    }



}
