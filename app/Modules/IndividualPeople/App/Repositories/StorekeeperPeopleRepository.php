<?php

namespace App\Modules\IndividualPeople\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\IndividualPeople\App\Data\ValueObject\StorekeeperPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople as Model;
use App\Modules\IndividualPeople\Domain\Actions\TypePeople\CreateStorekeeperPeopleAction;

class StorekeeperPeopleRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function save(StorekeeperPeopleVO $vo) : Model
    {
        return CreateStorekeeperPeopleAction::make($vo);
    }

    public function getById(string $uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }

}
