<?php

namespace App\Modules\Matrix\Common\Database\Seeders;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\GAR\Domain\Services\GARService;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectorLength\calculateVectorLength;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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

        $faker = Faker::create();


        foreach ($orders as $order) {

            /**
            * @var Address
            */
            $Address_start = $order->Address_start;

            /**
            * @var Address
            */
            $Address_end = $order->Address_end;

            $start_fias_id = $this->getFiasId($Address_start->city);
            $end_fias_id = $this->getFiasId($Address_end->city);

            MatrixDistance::factory()->create([
                "city_start_gar_id" => $start_fias_id,
                "city_end_gar_id" => $end_fias_id,
                "city_name_start" => $Address_start->city,
                "city_name_end" => $Address_end->city,
                "distance" => $this->calculateDistanceBetweenCities($Address_start->latitude, $Address_start->longitude, $Address_end->latitude, $Address_end->longitude),
            ]);

            //наоборот

            MatrixDistance::factory()->create([
                "city_start_gar_id" => $end_fias_id,
                "city_end_gar_id" => $start_fias_id,
                "city_name_start" => $Address_end->city,
                "city_name_end" => $Address_start->city,
                "distance" => $this->calculateDistanceBetweenCities($Address_end->latitude, $Address_end->longitude, $Address_start->latitude, $Address_start->longitude, $faker->numberBetween(5, 55)),
            ]);

        }
    }

    /**
     * Получаем значение fias Адресса
     * @param string $Address
     *
     * @return string
     */
    private function getFiasId(string $Address) : string
    {
        return $this->garService->run($Address)->getFiasId();
    }

    /**
     * Высчитывает дистанцию между координатами
     * @param float $lat1
     * @param float $lot1
     * @param float $lat2
     * @param float $lot2
     * @param int $randomDistance (по умолчанию 0) Необязательный параметр для добавлению случайного расстояния к актуальному расстоянию
     *
     * @return int
     */
    private function calculateDistanceBetweenCities(float $lat1, float $lot1, float $lat2, float $lot2, int $randomDistance = 0) : int
    {
        return $this->calculateVectorLength->run($lat1, $lot1, $lat2, $lot2, $randomDistance);
    }
}
