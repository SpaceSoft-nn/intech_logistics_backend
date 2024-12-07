<?php

namespace App\Modules\Matrix\Domain\Actions\Martix;

use App\Modules\Base\Error\BusinessException;
use App\Modules\Matrix\App\Data\DTO\MatrixDistanceVO;
use App\Modules\Matrix\Domain\Models\MatrixDistance;

use Exception;
use Illuminate\Database\UniqueConstraintViolationException;

use function App\Helpers\Mylog;

class MatrixDistanceCreateAction
{

    public static function make(MatrixDistanceVO $vo) : MatrixDistance
    {
        return (new self())->run($vo);
    }

    private function run(MatrixDistanceVO $vo) : MatrixDistance
    {


        try {

            $md = MatrixDistance::create($vo->toArrayNotNull());

        } catch (UniqueConstraintViolationException){

            throw new BusinessException('Такая запись городов уже существует.', 409);

        } catch (\Throwable $th) {

            Mylog('Ошибка при создании MatrixDistance в MatrixCreateAction: ' . $th);
            throw new Exception('Ошибка при создании MatrixDistance в Action {MatrixCreateAction}', 500);

        }

        return $md;
    }
}
