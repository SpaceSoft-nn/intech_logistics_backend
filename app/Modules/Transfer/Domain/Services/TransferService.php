<?php

namespace App\Modules\Transfer\Domain\Services;

use App\Modules\Transfer\App\Data\DTO\Transfer\CreateTransferServiceDTO;
use App\Modules\Transfer\Domain\Interactor\Transfer\TransferCreateInterctor;
use App\Modules\Transfer\Domain\Models\Transfer;

class TransferService
{


    public function __construct(
        private TransferCreateInterctor $interactorCreateTransfer,
    ) { }

    /**
     * Вызываем лоигку работы созданияы transfer
     * @param CreateTransferServiceDTO $dto
     *
     * @return ?Transfer
     */
    public function createTransfer(CreateTransferServiceDTO $dto) : ?Transfer
    {
        return $this->interactorCreateTransfer->execute($dto);
    }


}
