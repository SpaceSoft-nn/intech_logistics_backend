<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\Domain\Models\LotTender;

final class TenderService
{
    public function __construct() { }

    public function respondToTender(CreateLotTenderServiceDTO $dto) : LotTender
    {
        return $this->createLotTenderInteractor->execute($dto);
    }
}

