<?php

namespace App\Modules\Matrix\Domain\Services;

use App\Modules\Matrix\App\Data\DTO\MatrixDistanceShowDTO;
use App\Modules\Matrix\App\Data\ValueObject\MatrixDistanceVO;
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

    public function findMatrix(MatrixDistanceShowDTO $dto) : ?MatrixDistance
    {
        return $this->rep->show($dto);
    }
}
