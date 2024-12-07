<?php

namespace App\Modules\Matrix\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Matrix\App\Data\DTO\MatrixDistanceVO;
use App\Modules\Matrix\Domain\Actions\Martix\MatrixDistanceCreateAction;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Modules\User\Domain\Models\User as Model;


class MatrixDistanceRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function create(MatrixDistanceVO $vo) : MatrixDistance
    {
        return MatrixDistanceCreateAction::make($vo);
    }


}
