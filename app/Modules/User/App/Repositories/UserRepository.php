<?php

namespace App\Modules\User\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Actions\CreateUserAction;
use App\Modules\User\Domain\Interface\Repositories\IRepository;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User as Model;

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
    public function isOwnerPersonalArea(Model $model, ?string $uuid = null) : ?PersonalArea
    {
        if($uuid) {
            $model = $this->query()->find($uuid);
            $area = $model->personal_areas->where('owner_id', $model->id);
            return $area;
        }
        // ??
        return $this->query()
            ->with(['personal_areas' => function($query) use ($model) {
                $query->where('owner_id', $model->id);
            }])
            ->find($uuid)
            ->personal_areas;

            //РАБОТАЕМ
        $model = $user->query()
        ->with(['personal_areas' => function($query) use ($user) {
            $query->where('owner_id', $user->id);
        }])
        ->find($user->id)
        ->personal_areas->first();
    }

}
