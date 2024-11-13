<?php

namespace App\Modules\OrderUnit\Domain\Actions\Mgx;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\MgxVO;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use Exception;

use function App\Helpers\Mylog;

class MgxCreateAction
{

    public static function make(MgxVO $vo) : Mgx
    {
        return (new self())->run($vo);
    }

    private function run(MgxVO $vo) : Mgx
    {

        try {

            $mgx = Mgx::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            Mylog('Ошибка при создании Mgx в Action');
            throw new Exception('Ошибка при создании Mgx в Action', 500);

        }

        return $mgx;
    }
}
