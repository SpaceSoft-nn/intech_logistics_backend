<?php

namespace App\Modules\IndividualPeople\Domain\Actions\Passport;

use App\Modules\IndividualPeople\App\Data\ValueObject\PassportVO;
use App\Modules\IndividualPeople\Domain\Models\Passport;
use Exception;

use function App\Helpers\Mylog;

class CreatePassportAction
{

    public static function make(PassportVO $vo) : Passport
    {
        return self::run($vo);
    }


    private static function run(PassportVO $vo) : Passport
    {


        $model = Passport::create($vo->toArray());

        try {


        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
