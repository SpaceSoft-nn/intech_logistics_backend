<?php

namespace App\Modules\OrderUnit\Common\Database\Seeders;

use App\Modules\OrderUnit\App\Data\Enums\TransportationStatusEnum;
use App\Modules\OrderUnit\Domain\Models\Status\ChainTransportationStatus;
use App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus;
use Illuminate\Database\Seeder;


class EnumTransportationStatusSeeder extends Seeder
{
    public function run(): void
    {
        $this->createEnumTransporationStatusInDB();
    }

    private function createEnumTransporationStatusInDB()
    {
        foreach (TransportationStatusEnum::cases() as $status) {
            EnumTransportationStatus::create([
                'enum_name' => $status->name,
                'enum_value' => $status,
            ]);
        }

        ChainTransportationStatus::factory()->count(2)->create();
    }
}
