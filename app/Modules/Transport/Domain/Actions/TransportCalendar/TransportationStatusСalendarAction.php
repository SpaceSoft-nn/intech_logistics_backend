<?php

namespace App\Modules\Transport\Domain\Actions\TransportCalendar;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Transport\Domain\Models\TransportationStatusСalendar;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportationStatusСalendarVO;

class TransportationStatusСalendarAction
{
    public static function make(TransportationStatusСalendarVO $vo) : TransportationStatusСalendar
    {
        return (new self())->run($vo);
    }

    private function run(TransportationStatusСalendarVO $vo) : TransportationStatusСalendar
    {

        try {

            $transport = TransportationStatusСalendar::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $transport;
    }
}
