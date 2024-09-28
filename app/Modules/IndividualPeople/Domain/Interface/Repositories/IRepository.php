<?php

namespace App\Modules\IndividualPeople\Domain\Interface\Repositories;

use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function save(BaseDTO $dto) : IndividualPeople;
    public function getById(string $uuid) : ?Model;
}
