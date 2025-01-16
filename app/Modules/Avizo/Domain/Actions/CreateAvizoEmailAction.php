<?php

namespace App\Modules\Avizo\Domain\Actions;

use App\Modules\Avizo\App\Data\ValueObject\AvizoEmailVO;
use App\Modules\Avizo\Domain\Models\AvizoEmail;
use Exception;

use function App\Helpers\Mylog;

class CreateWeekPeriodAction
{

    public static function make(AvizoEmailVO $vo) : AvizoEmail
    {
        return (new self())->run($vo);
    }

    private function run(AvizoEmailVO $vo) : AvizoEmail
    {

        $model = AvizoEmail::create($vo->toArrayNotNull());

        try {

            // $model = WeekPeriod::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
