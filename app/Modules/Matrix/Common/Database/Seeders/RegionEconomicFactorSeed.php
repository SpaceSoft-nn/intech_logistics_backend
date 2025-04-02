<?php

namespace App\Modules\Matrix\Common\Database\Seeders;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\GAR\Domain\Services\GARService;
use App\Modules\Matrix\Domain\Models\RegionEconomicFactor;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectorLength\calculateVectorLength;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Seeder;

class RegionEconomicFactorSeed extends Seeder
{
    protected GARService $garService;
    public function __construct(

        GARService $garService,

    ) {
        $this->garService = $garService;
    }

    public function run(): void
    {
        $this->createMatrix();
    }

    private function createMatrix()
    {
        $orders = OrderUnit::all();

        //что бы мы могли без ограничение направить запрос в Dadata gar/fias
        sleep(2);

        foreach ($orders as $order) {

            /**
            * @var Address
            */
            $address_start = $order->address_start;

            /**
            * @var Address
            */
            $address_end = $order->address_end;

            //TODO Может быть проблема, что в зависимости от order - у нас будут повторяться записи Где Стар:Нижний Конец:Нижний - их нужно фильтровать и убирать из бд
            RegionEconomicFactor::factory()->create([
                "region_start_gar_id" => $this->getFiasId($address_start->region),
                "region_end_gar_id" => $this->getFiasId($address_end->region),
                "region_name_start" => $address_start->region,
                "region_name_end" => $address_end->region,
                "factor" => 1,
            ]);


        }
    }

    private function getFiasId(string $Address) : string
    {
        return $this->garService->run($Address)->getFiasId();
    }
}
