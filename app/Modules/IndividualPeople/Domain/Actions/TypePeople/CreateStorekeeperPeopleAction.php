<?php

namespace App\Modules\IndividualPeople\Domain\Actions\TypePeople;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople;
use App\Modules\IndividualPeople\App\Data\ValueObject\StorekeeperPeopleVO;

class CreateStorekeeperPeopleAction
{

    public static function make(StorekeeperPeopleVO $vo) : StorekeeperPeople
    {
        return self::run($vo);
    }


    private static function run(StorekeeperPeopleVO $vo) : StorekeeperPeople
    {

        try {

            $model = StorekeeperPeople::create($vo->toArray());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
