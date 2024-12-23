<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\Status\TransporationStatusVO;
use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;
use Exception;

use function App\Helpers\Mylog;

class CreateTransporationStatusAction
{

    public static function make(TransporationStatusVO $vo) : TransporationStatus
    {
        return self::run($vo);
    }


    private static function run(TransporationStatusVO $vo) : TransporationStatus
    {

        try {

            $transporationStatus = TransporationStatus::create($vo->toArray());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $transporationStatus;
    }
}
