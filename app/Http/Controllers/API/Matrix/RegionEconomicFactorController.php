<?php

namespace App\Http\Controllers\API\Matrix;

use App\Http\Controllers\Controller;
use App\Modules\Matrix\Domain\Models\RegionEconomicFactor;

class RegionEconomicFactorController extends Controller
{
    public function get()
    {
        //#TODO Большое количество записей, предусмотреть возврат и запись в память
        $regions = RegionEconomicFactor::all();

        return response()->json($regions);
    }
}
