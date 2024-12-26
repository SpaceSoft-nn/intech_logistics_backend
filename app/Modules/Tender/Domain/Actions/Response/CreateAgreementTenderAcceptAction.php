<?php

namespace App\Modules\Tender\Domain\Actions\Response;

use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderAcceptVO;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use Exception;

use function App\Helpers\Mylog;

class CreateAgreementTenderAcceptAction
{
    public static function make(AgreementTenderAcceptVO $vo) : AgreementTenderAccept
    {
        return (new self())->run($vo);
    }

    private function run(AgreementTenderAcceptVO $vo) : AgreementTenderAccept
    {
        try {

            $model = AgreementTenderAccept::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
