<?php

namespace App\Modules\IndividualPeople\Domain\Actions\TypePeople;

use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use Exception;

use function App\Helpers\Mylog;

class CreateDriverPeopleAction
{

    public static function make(DriverPeopleVO $vo) : DriverPeople
    {
        return self::run($vo);
    }


    private static function run(DriverPeopleVO $vo) : DriverPeople
    {

        try {

            $transporationStatus = DriverPeople::create($vo->toArray());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $transporationStatus;
    }
}
