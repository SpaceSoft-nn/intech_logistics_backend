<?php

namespace App\Modules\IndividualPeople\Domain\Services\TypePeople;

use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\App\Repositories\DriverPeopleRepository;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;

class DriverPeopleService
{
    public function __construct(
        public DriverPeopleRepository $rep,
    ) { }

    /**
     * Создание записи DriverPeople
     * @param DriverPeopleVO $vo
     *
     * @return DriverPeople
     */
    public function createDriverPeople(DriverPeopleVO $vo) : DriverPeople
    {
        return $this->rep->save($vo);
    }
}
