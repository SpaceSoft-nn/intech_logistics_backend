<?php

namespace App\Modules\Tender\Domain\Actions\Response;

use App\Modules\Tender\App\Data\ValueObject\Response\InvoiceLotTenderVO;
use App\Modules\Tender\Domain\Models\Response\InvoiceLotTender;
use Exception;

use function App\Helpers\Mylog;

class CreateInvoiceLotTenderAction
{
    public static function make(InvoiceLotTenderVO $vo) : InvoiceLotTender
    {
        return (new self())->run($vo);
    }

    private function run(InvoiceLotTenderVO $vo) : InvoiceLotTender
    {
        try {

            $model = InvoiceLotTender::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
