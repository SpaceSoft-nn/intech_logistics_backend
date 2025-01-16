<?php

namespace App\Modules\IndividualPeople\Domain\Services\TypePeople;

use App\Modules\IndividualPeople\App\Data\DTO\CreateDriverPeopleDTO;
use App\Modules\IndividualPeople\App\Repositories\DriverPeopleRepository;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use Illuminate\Support\Facades\DB;

class DriverPeopleService
{
    public function __construct(
        public DriverPeopleRepository $rep,
    ) { }

    /**
     * Создание записи DriverPeople
     * @param CreateDriverPeopleDTO $dto
     *
     * @return DriverPeople
     */
    public function createDriverPeople(CreateDriverPeopleDTO $dto) : DriverPeople
    {
        /** @var DriverPeople */
        $model = DB::transaction(function ($pdo) use ($dto) {

            /** @var DriverPeople */
            $driverPeople = $this->rep->save($dto->vo);

            /** @var IndividualPeople */
            $individual_people = IndividualPeople::find($dto->individual_people_id);
            #TODO Проверять нашли ли мы модель

            //сохраняем полиморфную связь
            $driverPeople->individual_people()->save($individual_people);

            return $driverPeople;

        });

        return $model;
    }
}
