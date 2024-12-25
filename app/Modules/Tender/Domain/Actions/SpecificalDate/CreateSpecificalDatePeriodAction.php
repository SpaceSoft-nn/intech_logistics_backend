<?php

namespace App\Modules\Tender\App\Data\ValueObject;

use App\Modules\Tender\Domain\Models\SpecificalDatePeriod;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\Domain\Models\Transport;
use Exception;

use function App\Helpers\Mylog;

class CreateSpecificalDatePeriodAction
{

    public static function make(SpecificalDatePeriodVO $vo) : SpecificalDatePeriod
    {
        return (new self())->run($vo);
    }

    private function run(SpecificalDatePeriodVO $vo) : SpecificalDatePeriod
    {

        try {

            $model = SpecificalDatePeriod::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
