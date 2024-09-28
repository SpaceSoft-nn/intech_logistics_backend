<?php

namespace App\Modules\Organization\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Organization\App\Data\DTO\Base\BaseDTO;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\Domain\Actions\CreateOrganizationAction;
use App\Modules\Organization\Domain\Interface\Repositories\IRepository;
use App\Modules\Organization\Domain\Models\Organization as Model;

class OrganizationRepository extends CoreRepository implements IRepository
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
     * @param OrganizationCreateDTO $dto
     *
     * @return Model
     */
    public function save(BaseDTO $dto) : Model
    {
        return CreateOrganizationAction::make($dto);
    }

    public function getById(string $uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }


}
