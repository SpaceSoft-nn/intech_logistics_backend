<?php

namespace App\Modules\Tender\Domain\Actions\Document;

use App\Modules\Tender\App\Data\ValueObject\AgreementDocumentTenderVO;
use App\Modules\Tender\Domain\Models\AgreementDocumentTender;
use App\Modules\Transport\Domain\Models\Transport;
use Exception;

use function App\Helpers\Mylog;

class CreateAgreementDocumentTenderAction
{
    public static function make(AgreementDocumentTenderVO $vo) : AgreementDocumentTender
    {
        return (new self())->run($vo);
    }

    private function run(AgreementDocumentTenderVO $vo) : AgreementDocumentTender
    {

        try {

            $model = AgreementDocumentTender::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
