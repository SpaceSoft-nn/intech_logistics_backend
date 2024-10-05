<?php

namespace App\Modules\PalletSpace\Common\Database\Seeders;

use App\Modules\PalletSpace\Domain\Models\PalletSpace;
use Illuminate\Database\Seeder;

class PalletSpaceSeeder extends Seeder
{
    public function run(): void
    {
        $this->createPalletSpace();
    }

    private function createPalletSpace()
    {
        $pallet = PalletSpace::factory()->create();
    }

}
