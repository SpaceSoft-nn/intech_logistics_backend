<?php

namespace App\Modules\Matrix\Domain\Services;

use App\Modules\Matrix\App\Data\DTO\MatrixDistanceVO;
use App\Modules\Matrix\App\Repositories\MatrixDistanceRepository;
use App\Modules\Matrix\Domain\Models\MatrixDistance;

class MatrixService
{

    public function __construct(
        private MatrixDistanceRepository $rep,
    ) { }

    public function createMatrix(MatrixDistanceVO $vo) : MatrixDistance
    {
        return $this->rep->create($vo);
    }
}
