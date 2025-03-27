<?php

namespace App\Modules\IndividualPeople\Domain\Services\TypePeople;

use App\Modules\Base\Error\BusinessException;
use Illuminate\Support\Facades\DB;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\App\Data\DTO\CreateDriverPeopleDTO;
use App\Modules\IndividualPeople\App\Repositories\DriverPeopleRepository;
use App\Modules\IndividualPeople\Domain\Actions\TypePeople\DriverPeople\UpdateDriverPeopleAction;

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

            if(is_null($individual_people))
            {
                throw new BusinessException('Individual people - не найден.' , 404);
            }

            //сохраняем полиморфную связь
            $driverPeople->individual_people()->save($individual_people);

            return $driverPeople;

        });

        return $model;
    }

    public function updateDriverPeople(CreateDriverPeopleDTO $dto, DriverPeople $driverPeople) : DriverPeople
    {
        /** @var DriverPeople */
        $model = DB::transaction(function ($pdo) use ($dto, $driverPeople) {

            /** @var DriverPeople */
            $model = UpdateDriverPeopleAction::make($dto->vo, $driverPeople);

            if($driverPeople->individual_people->id !== $dto->individual_people_id)
            {

                { // очищаем запись
                    $related = $driverPeople->individual_people;
                    $related->individualable_id = null;
                    $related->individualable_type = null;
                    $related->save();
                }

                {
                    //устанавливаем новую связь
                    $indPeople = IndividualPeople::find($dto->individual_people_id);
                    $indPeople->individualable()->associate($driverPeople);
                    $indPeople->save();

                }

            }

            //что бы фронт получил актуальные данные
            $model->refresh()->load('individual_people');

            return $model;

        });

        return $model;
    }
}
