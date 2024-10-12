<?php

namespace App\Modules\Matrix\Common\Database\Seeders;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\GAR\Domain\Services\GARService;
use App\Modules\Matrix\Domain\Models\RegionEconomicFactor;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectorLength\calculateVectorLength;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Seeder;

class RegionEconomicFactorSeed extends Seeder
{
    protected GARService $garService;
    protected calculateVectorLength $calculateVectorLength; // Высчитывание расстояние по координатам

    public function __construct(

        GARService $garService,
        calculateVectorLength $calculateVectorLength,

    ) {
        $this->garService = $garService;
        $this->calculateVectorLength = $calculateVectorLength;
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
            * @var Adress
            */
            $adress_start = $order->adress_start;

            /**
            * @var Adress
            */
            $adress_end = $order->adress_end;

            //TODO Может быть проблема, что в зависимости от order - у нас будут повторяться записи Где Стар:Нижний Конец:Нижний - их нужно фильтровать и убирать из бд
            RegionEconomicFactor::factory()->create([
                "region_start_gar_id" => $this->getFiasId($adress_start->region),
                "region_end_gar_id" => $this->getFiasId($adress_end->region),
                "region_name_start" => $adress_start->region,
                "region_name_end" => $adress_end->region,
                "factor" => 1,
            ]);


        }
    }

    private function getFiasId(string $adress) : string
    {
        return $this->garService->run($adress)->getFiasId();
    }
}
