<?php

namespace App\Modules\Tender\Domain\Actions\Response;

use App\Modules\Tender\App\Data\ValueObject\Response\LotTenderResponseVO;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;
use Exception;

use function App\Helpers\Mylog;

class CreateLotTenderResponseAction
{
    public static function make(LotTenderResponseVO $vo) : LotTenderResponse
    {
        return (new self())->run($vo);
    }

    private function run(LotTenderResponseVO $vo) : LotTenderResponse
    {
        try {

            $model = LotTenderResponse::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
