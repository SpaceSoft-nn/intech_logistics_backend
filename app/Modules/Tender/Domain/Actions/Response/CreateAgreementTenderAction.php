<?php

namespace App\Modules\Tender\Domain\Actions\Response;

use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderVO;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use Exception;

use function App\Helpers\Mylog;

class CreateAgreementTenderAction
{
    public static function make(AgreementTenderVO $vo) : AgreementTender
    {
        return (new self())->run($vo);
    }

    private function run(AgreementTenderVO $vo) : AgreementTender
    {
        try {

            $model = AgreementTender::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
