<?php

namespace App\Modules\Tender\Domain\Actions\LotTender;

use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Transport\Domain\Models\Transport;
use Exception;

use function App\Helpers\Mylog;

class CreateLotTenderAction
{
    public static function make(LotTenderVO $vo) : LotTender
    {
        return (new self())->run($vo);
    }

    private function run(LotTenderVO $vo) : LotTender
    {

        try {

            $model = LotTender::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
