<?php

namespace App\Modules\Transport\Common\Database\Seeders;

use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{

    public function run(): void
    {
        $this->createTransport(TransportStatusEnum::free);
        $this->createTransport(TransportStatusEnum::repair);
        $this->createTransport(TransportStatusEnum::work);
    }

    private function createTransport(TransportStatusEnum $enum)
    {
        Transport::factory()->create([
            "type_status" => $enum,
        ]);
    }

}
