<?php

namespace App\Modules\IndividualPeople\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\Domain\Actions\CreateIndividualPeople;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople as Model;
use App\Modules\IndividualPeople\Domain\Interface\Repositories\IRepository;

class IndividualPeopleRepository extends CoreRepository implements IRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    /**
     * #TODO - тут был DTO - поменял на VO, могут быть ошибки в других частях кода
     * @param IndividualPeopleVO $vo
     *
     * @return Model
    */
    public function save(BaseDTO $dto) : Model
    {
        return CreateIndividualPeople::make($vo);
    }

    public function getById(string $uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }

    public function findByEmail(string $email) : ?Model
    {
        return $this->query()->where('email', $email)->first();
    }

}
