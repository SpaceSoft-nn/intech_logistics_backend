<?php

namespace App\Modules\IndividualPeople\Domain\Actions;

use App\Modules\IndividualPeople\App\Data\ValueObject\IndividualPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use Exception;

use function App\Helpers\Mylog;

class CreateIndividualPeople
{


    public static function make(IndividualPeopleVO $vo) : IndividualPeople
    {
        return (new self())->run($vo);
    }

    public function run(IndividualPeopleVO $vo) : IndividualPeople
    {


        try {

            $model = IndividualPeople::query()
                ->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
