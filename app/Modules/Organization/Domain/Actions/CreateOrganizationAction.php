<?php

namespace App\Modules\Organization\Domain\Actions;

use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Models\Organization as Model;

class CreateOrganizationAction
{
    public static function make(OrganizationVO $vo) : Model
    {
       return (new self())->run($vo);
    }

    public function run(OrganizationVO $vo) : Model
    {
        $model = Model::query()
            ->createOrFirst($vo->toArrayNotNull());

        return $model;
    }
}
