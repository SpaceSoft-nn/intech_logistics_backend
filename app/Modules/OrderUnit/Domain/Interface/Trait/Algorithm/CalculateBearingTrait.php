<?php

namespace App\Modules\OrderUnit\Domain\Interface\Trait\Algorithm;

trait CalculateBearingTrait
{
    /**
    * Вычисляет угол азимута.
    */
    public function calculateBearing($lat1, $lng1, $lat2, $lng2) {

        //Вычисление разности долготы между двумя точками (в радианах).
        $deltaLng = deg2rad($lng2 - $lng1);

        //Преобразование широты обеих точек из градусов в радианы.
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);

        //Вычисление компонентов y и x:
        $y = sin($deltaLng) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($deltaLng);

        $bearing = rad2deg(atan2($y, $x));

        return (fmod($bearing + 360, 360)); // в градусах
    }
}
