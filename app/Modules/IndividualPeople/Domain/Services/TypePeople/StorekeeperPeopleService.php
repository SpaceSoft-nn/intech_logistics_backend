<?php

namespace App\Modules\IndividualPeople\Domain\Services\TypePeople;

use App\Modules\IndividualPeople\App\Data\ValueObject\StorekeeperPeopleVO;
use App\Modules\IndividualPeople\App\Repositories\StorekeeperPeopleRepository;
use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople;

class StorekeeperPeopleService
{
    public function __construct(
        public StorekeeperPeopleRepository $rep,
    ) { }

    /**
     * Создание записи StorekeeperPeople
     * @param StorekeeperPeopleVO $vo
     *
     * @return StorekeeperPeople
     */
    public function createStorekeeperPeople(StorekeeperPeopleVO $vo) : StorekeeperPeople
    {
        return $this->rep->save($vo);
    }
}
