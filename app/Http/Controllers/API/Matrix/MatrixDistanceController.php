<?php

namespace App\Http\Controllers\API\Matrix;

use App\Http\Controllers\Controller;
use App\Modules\Matrix\Domain\Models\MatrixDistance;

class MatrixDistanceController extends Controller
{
    public function get()
    {
        //#TODO Большое количество записей, предусмотреть возврат и запись в память
        $matrix = MatrixDistance::all();

        return response()->json($matrix);
    }
}
