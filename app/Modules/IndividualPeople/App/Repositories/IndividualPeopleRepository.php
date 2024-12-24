<?php

namespace App\Modules\IndividualPeople\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\Domain\Actions\CreateIndividualPeople;
use App\Modules\IndividualPeople\Domain\Interface\Repositories\IRepository;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople as Model;

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
     * @param CreateIndividualPeopleDTO $dto
     *
     * @return Model
    */
    public function save(BaseDTO $dto) : Model
    {
        return CreateIndividualPeople::make($dto);
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
