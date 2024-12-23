<?php

namespace App\Modules\OrderUnit\Common\Database\Seeders;

use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;
use Illuminate\Database\Seeder;


class TransporationStatusSeeder extends Seeder
{
    public function run(): void
    {
        $this->createEnumTransporationStatus();
    }

    private function createEnumTransporationStatus()
    {
        TransporationStatus::factory()->count(3)->create();
    }
}
