<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Tender\App\Data\DTO\AddInfoOrderByTenderDTO;
use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\Domain\Interactor\AddInfoOrderByTenderInteractor;
use App\Modules\Tender\Domain\Interactor\CreateLotTenderInteractor;
use App\Modules\Tender\Domain\Models\LotTender;

final class TenderService
{
    public function __construct(
        private CreateLotTenderInteractor $createLotTenderInteractor,
        private AddInfoOrderByTenderInteractor $addInfoOrderByTenderInteractor,
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


    /**
     * Дополняем важной информацией заказ по тендеру
     * @param AddInfoOrderByTenderDTO $dto
     *
     * @return OrderUnit
    */
    public function addInfoOrderByTender(AddInfoOrderByTenderDTO $dto) : OrderUnit
    {
        return $this->addInfoOrderByTenderInteractor->execute($dto);
    }


}

