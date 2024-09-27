<?php

namespace App\Modules\User\App\Repositories;

use App\Modules\Base\CoreRepository;
use App\Modules\User\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\App\Data\DTO\UserCreateDTO;
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

    /**
     * @param UserCreateDTO $dto
     *
     * @return Model|null
     */
    public function save(BaseDTO $dto) : Model
    {
        return CreateUserAction::make($dto);
    }

    public function getById($uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }


    public function isOwnerPersonalArea(Model $model, ?string $uuid ) : ?PersonalArea
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
    }

}
