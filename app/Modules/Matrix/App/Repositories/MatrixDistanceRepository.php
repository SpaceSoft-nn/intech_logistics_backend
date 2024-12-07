<?php

namespace App\Modules\Matrix\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Matrix\App\Data\DTO\MatrixDistanceShowDTO;
use App\Modules\Matrix\App\Data\ValueObject\MatrixDistanceVO;
use App\Modules\Matrix\Domain\Actions\Martix\MatrixDistanceCreateAction;
use App\Modules\Matrix\Domain\Models\MatrixDistance as Model;


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

    public function create(MatrixDistanceVO $vo) : Model
    {
        return MatrixDistanceCreateAction::make($vo);
    }

    public function show(MatrixDistanceShowDTO $dto) : ?Model
    {

        // dd($this->query()->where($dto->toArrayNotNull())->dd());

        return $this->query()->where($dto->toArrayNotNull())->first();
    }


}
