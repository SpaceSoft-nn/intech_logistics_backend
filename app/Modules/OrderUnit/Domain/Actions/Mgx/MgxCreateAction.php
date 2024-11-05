<?php

namespace App\Modules\OrderUnit\Domain\Actions\MGX;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\MgxVO;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use Exception;

use function App\Helpers\Mylog;

class MgxCreateAction
{

    private function __construct(){ }

    public static function make(MgxVO $vo) : ?Mgx
    {
        return self::run($vo);
    }

    private static function run(MgxVO $vo) : ?MgxVO
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
