<?php

namespace App\Modules\IndividualPeople\Domain\Actions;

use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople as Model;

class CreateIndividualPeople
{

    /**
     * @param CreateIndividualPeopleDTO $dto
     *
     * @return Model
     */
    public static function make(BaseDTO $dto) : Model
    {
        return (new self())->run($dto);
    }

    public function run(CreateIndividualPeopleDTO $dto) : Model
    {
        $model = Model::query()
            ->create($dto->toArrayNotNull());

        return $model;
    }
}
