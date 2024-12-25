<?php

namespace App\Modules\Tender\Domain\Actions\Document;

use App\Modules\Tender\App\Data\ValueObject\ApplicationDocumentTenderVO;
use App\Modules\Tender\Domain\Models\ApplicationDocumentTender;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\Domain\Models\Transport;
use Exception;

use function App\Helpers\Mylog;

class CreateApplicationDocumentTenderAction
{
    public static function make(ApplicationDocumentTenderVO $vo) : ApplicationDocumentTender
    {
        return (new self())->run($vo);
    }

    private function run(ApplicationDocumentTenderVO $vo) : ApplicationDocumentTender
    {

        try {

            $model = ApplicationDocumentTender::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
