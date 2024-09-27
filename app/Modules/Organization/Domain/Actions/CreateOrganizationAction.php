<?php

namespace App\Modules\Organization\Domain\Actions;

use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\Domain\Models\Organization as Model;

class CreateOrganizationAction
{
    public static function make(OrganizationCreateDTO $dto) : Model
    {
       return (new self())->run($dto);
    }

    public function run(OrganizationCreateDTO $dto) : Model
    {
        $model = Model::query()
            ->create($dto->toArrayNotNull());

        return $model;
    }
}
