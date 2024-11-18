<?php

namespace App\Modules\Transfer\Domain\Actions\Transfer;

use App\Modules\Transfer\App\Data\ValueObject\TransferVO;
use App\Modules\Transfer\Domain\Models\Transfer;
use Exception;

class TransferCreateAction
{
    public static function make(
        TransferVO $vo
    ) : ?Transfer {

        return (new self())->run($vo);

    }

    private function run(TransferVO $vo) : ?Transfer
    {
        dd($vo);

        try {
            $model = Transfer::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            throw new Exception('Ошибка в TransferCreateAction', 500);

        }

        return $model;
    }
}
