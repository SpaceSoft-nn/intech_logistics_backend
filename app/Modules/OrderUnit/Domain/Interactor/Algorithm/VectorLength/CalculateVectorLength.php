<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectorLength;

/**
 * Класс высчитывает расстояние между координатами и учитывая радиус земли и кривизну земли
 */
class calculateVectorLength
{
    public function run(float $lat1, float $lon1, float $lat2, float $lon2) : int
    {
        return $this->calculateDistance($lat1, $lon1, $lat2, $lon2);
    }

    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2) {
        $earthRadius = 6371; // Радиус Земли в километрах

        // Преобразование градусов в радианы
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Возвращает расстояние в километрах
    }
}
