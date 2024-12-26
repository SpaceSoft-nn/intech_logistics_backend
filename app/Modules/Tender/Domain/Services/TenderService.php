<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\Domain\Interactor\CreateLotTenderInteractor;

final class TenderService
{
    public function __construct(
        private CreateLotTenderInteractor $createLotTenderInteractor,
    ) { }


    /**
     * Полное Создание LotTender - с ?файлами + ?адрессами
     * @param CreateLotTenderServiceDTO $dto
     *
     * @return [type]
     */
    public function createLotTender(CreateLotTenderServiceDTO $dto)
    {
        return $this->createLotTenderInteractor->execute($dto);
    }
}

