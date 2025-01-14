<?php

namespace App\Modules\Tender\Domain\Actions\SpecificalDate;

use App\Modules\Tender\App\Data\ValueObject\WeekPeriodVO;
use App\Modules\Tender\Domain\Models\WeekPeriod;
use Exception;

use function App\Helpers\Mylog;

class CreateWeekPeriodAction
{

    public static function make(WeekPeriodVO $vo) : WeekPeriod
    {
        return (new self())->run($vo);
    }

    private function run(WeekPeriodVO $vo) : WeekPeriod
    {

        $model = WeekPeriod::create($vo->toArrayNotNull());

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
