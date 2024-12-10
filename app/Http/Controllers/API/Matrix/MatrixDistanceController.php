<?php

namespace App\Http\Controllers\API\Matrix;

use App\Http\Controllers\Controller;
use App\Modules\Matrix\App\Data\DTO\MatrixDistanceShowDTO;
use App\Modules\Matrix\App\Data\ValueObject\MatrixDistanceVO;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Modules\Matrix\Domain\Requests\Matrix\MatrixDistanceRequest;
use App\Modules\Matrix\Domain\Requests\Matrix\MatrixDistanceShowRequest;
use App\Modules\Matrix\Domain\Resources\MatrixDistanceResource;
use App\Modules\Matrix\Domain\Services\MatrixService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class MatrixDistanceController extends Controller
{

    public function index()
    {
        //#TODO Большое количество записей, предусмотреть возврат и запись *в память (chank)
        $matrix = MatrixDistance::all();

        return response()->json($matrix);
    }


    public function show(
        MatrixDistanceShowRequest $request,
        MatrixService $serviceMatrix,
    ) {
        #TODO - Сделать потом что бы сравнения было не по string, а по gar_id (индефикатора города)
        /**
         * @var MatrixDistanceShowDTO
         */
        $matrixDistanceShowDTO = $request->createMatrixDistanceShowDTO();

        /**
        * @var MatrixDistance
        */
        $matrixDistance = $serviceMatrix->findMatrix($matrixDistanceShowDTO);


        return response()->json(array_success(MatrixDistanceResource::make($matrixDistance), 'Get Matrix Distance.'), 200);
    }


    public function store(
        MatrixDistanceRequest $request,
        MatrixService $serviceMatrix,
    ) {
        /**
        * @var MatrixDistanceVO
        */
        $matrixVO = $request->createMatrixDistanceVO();

        $matrixDistance = $serviceMatrix->createMatrix($matrixVO);

        return $matrixDistance ?
        response()->json(array_success(MatrixDistanceResource::make($matrixDistance), 'Create matrix distance.'), 201)
        :
        response()->json(array_error(MatrixDistanceResource::make($matrixDistance), 'Faild create matrix distance.'), 404);
    }

}
