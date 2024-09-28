<?php

namespace App\Modules\IndividualPeople\Domain\Interface\Service;

use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;

interface IIndividualPeopleService
{
    public function createIndividualPeople(BaseDTO $dto) : IndividualPeople;
    public function getIndividualPeople(string $uuid) :  ?IndividualPeople;
}
