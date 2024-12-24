<?php

namespace App\Modules\IndividualPeople\Domain\Services\TypePeople;

use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Actions\TypePeople\CreateDriverPeopleAction;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;

class DriverPeopleService
{
    /**
     * Создание записи DriverPeople
     * @param DriverPeopleVO $vo
     *
     * @return DriverPeople
     */
    public function createDriverPeople(DriverPeopleVO $vo) : DriverPeople
    {
        return CreateDriverPeopleAction::make($vo);
    }
}
