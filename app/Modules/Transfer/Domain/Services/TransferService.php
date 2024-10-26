<?php

namespace App\Modules\Transfer\Domain\Services;

use App\Modules\Transfer\App\Data\DTO\Transfer\CreateTransferServiceDTO;
use App\Modules\Transfer\Domain\Interactor\Transfer\TransferCreateInterctor;

class TransferService
{


    public function __construct(
        private TransferCreateInterctor $interactorCreateTransfer,
    ) { }


    public function createTransfer(CreateTransferServiceDTO $dto)
    {
        return $this->interactorCreateTransfer->execute($dto);
    }

    /**
     * Создаём transfer и делаем логику остальных привязок
     * @return [type]
     */
    private function createTransferAndLink()
    {

    }
}
