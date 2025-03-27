<?php

namespace App\Modules\Transport\Domain\Actions\Transport;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Transport\Domain\Models\Transport;

use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;

final class UpdateTransportAction
{
    public static function make(TransportVO $vo, Transport $transport) : Transport
    {
        return (new self())->run($vo, $transport);
    }

    private function run(TransportVO $vo, Transport $transport) : Transport
    {

        try {

            $transport = $transport->fill($vo->toArrayNotNull());


           //проверяем данные на 'грязь' - если данные отличаются от старого состояние модели, то обновляем сущность
           if ($transport->isDirty()) { $transport->save(); $transport->refresh(); }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $transport;
    }
}
