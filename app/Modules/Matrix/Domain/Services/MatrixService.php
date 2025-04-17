<?php

namespace App\Modules\Matrix\Domain\Services;

use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Modules\Matrix\App\Data\DTO\MatrixDistanceShowDTO;
use App\Modules\Matrix\App\Data\DTO\RegionEconomicFactorDTO;
use App\Modules\Matrix\App\Data\ValueObject\MatrixDistanceVO;
use App\Modules\Matrix\App\Repositories\MatrixDistanceRepository;
use App\Modules\Matrix\App\Data\DTO\CreateRegionEconomicFactorDTO;
use App\Modules\Matrix\Domain\Interactors\SetRegionEconomicFactorInteractor;
use App\Modules\Matrix\Domain\Models\RegionEconomicFactor;

class MatrixService
{

    public function __construct(
        private MatrixDistanceRepository $rep,
        private SetRegionEconomicFactorInteractor $setRegionEconomicFactorInteractor,
    ) { }

    public function createMatrix(MatrixDistanceVO $vo) : MatrixDistance
    {
        return $this->rep->create($vo);
    }

    public function findMatrix(MatrixDistanceShowDTO $dto) : ?MatrixDistance
    {
        return $this->rep->show($dto);
    }

    public function createRegionEconomicFactor(CreateRegionEconomicFactorDTO $dto) : RegionEconomicFactor
    {
        return $this->setRegionEconomicFactorInteractor->execute($dto);
    }
}
