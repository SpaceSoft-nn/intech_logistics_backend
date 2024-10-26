<?php

namespace App\Modules\InteractorModules\AgreementTransfer\Domain\Actions;

use App\Modules\InteractorModules\AgreementTransfer\App\Data\DTO\LinkAgreementToTransferDTO;
use Exception;

use function App\Helpers\Mylog;

class LinkAgreementToTransferAction
{
    public static function run(LinkAgreementToTransferDTO $dto) : bool
    {

        try {

            //Сохраняем связь от AgreementOrder к Transfer
            $dto->agreementOrder->transfers()->syncWithoutDetaching([
                $dto->transfer->id => ['order_main' => $dto->order_main]
            ]);

            return true;

        } catch (\Throwable $th) {

            Mylog('Ошибка в LinkAgreementToTransferAction' . $th);
            throw new Exception('Ошибка в LinkAgreementToTransferAction', 500);
            return false;

        }

    }
}
