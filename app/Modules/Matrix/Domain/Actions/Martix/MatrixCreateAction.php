<?php

namespace App\Modules\Matrix\Domain\Actions\Martix;

use App\Modules\Matrix\App\Data\DTO\MatrixDistanceVO;
use App\Modules\Matrix\Domain\Models\MatrixDistance;

use Exception;

use function App\Helpers\Mylog;

class MatrixCreateAction
{

    public static function make(MatrixDistanceVO $vo) : MatrixDistance
    {
        return (new self())->run($vo);
    }

    private function run(MatrixDistanceVO $vo) : MatrixDistance
    {

        try {

            $mgx = MatrixDistance::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            Mylog('Ошибка при создании MatrixDistance в MatrixCreateAction: ' . $th);
            throw new Exception('Ошибка при создании MatrixDistance в Action {MatrixCreateAction}', 500);

        }

        return $mgx;
    }
}
