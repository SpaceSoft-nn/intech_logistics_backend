<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\Domain\Interactor\CreateLotTenderInteractor;
use App\Modules\Tender\Domain\Models\LotTender;

final class TenderService
{
    public function __construct(
        private CreateLotTenderInteractor $createLotTenderInteractor,
    ) { }


    /**
     * Полное Создание LotTender - с ?файлами + ?адрессами
     * @param CreateLotTenderServiceDTO $dto
     *
     * @return LotTender
     */
    public function createLotTender(CreateLotTenderServiceDTO $dto) : LotTender
    {
        return $this->createLotTenderInteractor->execute($dto);
    }


}

