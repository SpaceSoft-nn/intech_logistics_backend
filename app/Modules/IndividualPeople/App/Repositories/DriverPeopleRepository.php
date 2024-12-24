<?php

namespace App\Modules\IndividualPeople\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Actions\TypePeople\CreateDriverPeopleAction;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople as Model;

class DriverPeopleRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function save(DriverPeopleVO $vo) : Model
    {
        return CreateDriverPeopleAction::make($vo);
    }

    public function getById(string $uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }



}
