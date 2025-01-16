<?php

namespace App\Modules\IndividualPeople\Domain\Services\TypePeople;

use App\Modules\IndividualPeople\App\Data\DTO\CreateStorekeeperPeopleDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\StorekeeperPeopleVO;
use App\Modules\IndividualPeople\App\Repositories\StorekeeperPeopleRepository;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople;
use DB;

class StorekeeperPeopleService
{
    public function __construct(
        public StorekeeperPeopleRepository $rep,
    ) { }

    /**
     * Создание записи StorekeeperPeople
     * @param CreateStorekeeperPeopleDTO $vo
     *
     * @return StorekeeperPeople
     */
    public function createStorekeeperPeople(CreateStorekeeperPeopleDTO $dto) : StorekeeperPeople
    {
         /** @var StorekeeperPeople */
         $model = DB::transaction(function ($pdo) use ($dto) {

            /** @var StorekeeperPeople */
            $storekeeperPeople = $this->rep->save($dto->vo);

            /** @var IndividualPeople */
            $individual_people = IndividualPeople::find($dto->individual_people_id);
            #TODO Проверять нашли ли мы модель

            //сохраняем полиморфную связь
            $storekeeperPeople->individual_people()->save($individual_people);

            return $storekeeperPeople;

        });

        return $model;
    }
}
