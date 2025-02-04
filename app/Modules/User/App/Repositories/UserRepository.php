<?php

namespace App\Modules\User\App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\InteractorModules\Registration\Domain\Model\UserOrganization;
use App\Modules\User\Domain\Models\User as Model;
use App\Modules\User\Domain\Actions\CreateUserAction;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Interface\Repositories\IRepository;

class UserRepository extends CoreRepository implements IRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function save(UserVO $vo) : Model
    {
        return CreateUserAction::make($vo);
    }


    /**
     * @param string $uuid
     *
     * @return Model|null
     */
    public function getById($uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }


    #TODO Проверить/ изменить
    public function isOwnerPersonalArea(Model $model) : ?PersonalArea
    {
        $user = $this->query()->whereRelation('personal_areas', 'owner_id', '=', $model->id)->first();

        return $user->personal_areas->first();
    }

    /**
     * Вернуть всех пользователей которые принадлежат организации
     * @param Organization $model
     *
     * @return Collection
     */
    public function getUsersByOrganization(Organization $organization) : Collection
    {

        $userOrganization = UserOrganization::where('organization_id', $organization->id)->with('user')->get();

        // dd($userOrganization->pluck('user'));

        $users = $userOrganization->filter(function ($userOrganization) use ($organization) {

            // Исключаем администратора организации
            return $userOrganization->user->id !== $organization->owner_id;

        })->map(function ($userOrganization) {
            return $userOrganization->user;
        });

        return $users;
    }

}
