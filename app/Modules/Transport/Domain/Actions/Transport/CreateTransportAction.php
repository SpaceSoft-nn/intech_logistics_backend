<?php

namespace App\Modules\Transport\Domain\Actions\Transport;

use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\Domain\Models\Transport;
use Exception;

use function App\Helpers\Mylog;

class CreateTransportAction
{
    public static function make(TransportVO $vo) : Transport
    {
        return (new self())->run($vo);
    }

    private function run(TransportVO $vo) : Transport
    {

        try {

            $transport = Transport::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            Mylog('Ошибка при создании Transport в CreateTransportAction: ' . $th);
            throw new Exception('Ошибка при создании Transport в CreateTransportAction', 500);

        }

        return $transport;
    }
}
