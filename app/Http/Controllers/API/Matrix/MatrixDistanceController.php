<?php

namespace App\Http\Controllers\API\Matrix;

use App\Http\Controllers\Controller;
use App\Modules\Matrix\App\Data\DTO\MatrixDistanceVO;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Modules\Matrix\Domain\Requests\Matrix\MatrixDistanceRequest;

class MatrixDistanceController extends Controller
{

    public function index()
    {
        //#TODO Большое количество записей, предусмотреть возврат и запись в память
        $matrix = MatrixDistance::all();

        return response()->json($matrix);
    }

    public function show()
    {

    }

    public function create(MatrixDistanceRequest $request)
    {
        /**
         * @var MatrixDistanceVO
         */
        $matrixVO = $request->createMatrixDistanceVO();

    }

}
