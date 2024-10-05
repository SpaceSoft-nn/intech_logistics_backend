<?php

namespace App\Modules\Transport\Common\Database\Seeders;

use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{

    public function run(): void
    {
        $this->createTransport();
    }

    private function createTransport()
    {
        Transport::factory()->create([
            "body_volume" => 95,
            "body_weight" => 45000,
        ]);
    }

}
