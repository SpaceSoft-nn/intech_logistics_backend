<?php

namespace App\Modules\IndividualPeople\Domain\Actions\TypePeople\DriverPeople;

use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use Exception;

use function App\Helpers\Mylog;

class UpdateDriverPeopleAction
{

    public static function make(DriverPeopleVO $vo, DriverPeople $model) : DriverPeople
    {
        return self::run($vo, $model);
    }


    private static function run(DriverPeopleVO $vo, DriverPeople $model) : DriverPeople
    {

        try {

            $model = $model->fill($vo->toArrayNotNull());

           //проверяем данные на 'грязь' - если данные отличаются от старого состояние модели, то обновляем сущность
           if ($model->isDirty()) { $model->save(); $model->refresh(); }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
