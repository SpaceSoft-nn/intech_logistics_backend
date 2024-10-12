<?php

namespace App\Modules\Matrix\Common\Database\Seeders;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\GAR\Domain\Services\GARService;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectorLength\calculateVectorLength;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Seeder;

class MatrixDistanceSeed extends Seeder
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

        foreach ($orders as $order) {

            /**
            * @var Adress
            */
            $adress_start = $order->adress_start;

            /**
            * @var Adress
            */
            $adress_end = $order->adress_end;

            $start_fias_id = $this->getFiasId($adress_start->city);
            $end_fias_id = $this->getFiasId($adress_end->city);

            MatrixDistance::factory()->create([
                "city_start_gar_id" => $start_fias_id,
                "city_end_gar_id" => $end_fias_id,
                "city_name_start" => $adress_start->city,
                "city_name_end" => $adress_end->city,
                "distance" => $this->calculateDistanceBetweenCities($adress_start->latitude, $adress_start->longitude, $adress_end->latitude, $adress_end->longitude),
            ]);

            //наоборот

            MatrixDistance::factory()->create([
                "city_start_gar_id" => $end_fias_id,
                "city_end_gar_id" => $start_fias_id,
                "city_name_start" => $adress_end->city,
                "city_name_end" => $adress_start->city,
                "distance" => $this->calculateDistanceBetweenCities($adress_end->latitude, $adress_end->longitude, $adress_start->latitude, $adress_start->longitude),
            ]);

        }
    }

    /**
     * Получаем значение fias Адресса
     * @param string $adress
     *
     * @return string
     */
    private function getFiasId(string $adress) : string
    {
        return $this->garService->run($adress)->getFiasId();
    }

    /**
     * Высчитывает дистанцию между координатами
     * @param float $lat1
     * @param float $lot1
     * @param float $lat2
     * @param float $lot2
     *
     * @return int
     */
    private function calculateDistanceBetweenCities(float $lat1, float $lot1, float $lat2, float $lot2) : int
    {
        return $this->calculateVectorLength->run($lat1, $lot1, $lat2, $lot2);
    }
}
