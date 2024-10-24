<?php

namespace App\Modules\Transfer\Common\Database\Seeders;

use App\Modules\Transfer\Domain\Models\Transfer;
use Illuminate\Database\Seeder;


class TransferSeeder extends Seeder
{

    public function run(): void
    {
        $this->createTransfer();
    }

    private function createTransfer()
    {
        Transfer::factory()->count(4)->create();
    }

}
