<?php

namespace App\Modules\Organization\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Actions\CreateOrganizationAction;
use App\Modules\Organization\Domain\Interface\Repositories\IRepository;
use App\Modules\Organization\Domain\Models\Organization as Model;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;

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
     * @param OrganizationVO $dto
     *
     * @return Model
     */
    public function save($dto) : Model
    {
        return CreateOrganizationAction::make($dto);
    }

    public function getById(string $uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }

    /**
     * Возвращаем тип кабинета по User + Organization
     * @param User $user
     * @param Organization $organization
     *
     * @return TypeCabinetEnum|null
     */
    public function getTypeCabinet(User $user, Organization $organization) : ?TypeCabinetEnum
    {
        $userOrganization = $user->organizations->firstWhere('id', $organization->id);

        $typeCabinet = TypeCabinetEnum::returnObjectByString($userOrganization->pivot->type_cabinet);

        return $typeCabinet;
    }


}
