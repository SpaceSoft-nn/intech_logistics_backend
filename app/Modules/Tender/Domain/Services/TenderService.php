<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\Tender\Domain\Interactor\CreateLotTenderInteractor;

final class TenderService
{
    public function __construct(
        private CreateLotTenderInteractor $createLotTenderInteractor,
    ) { }


    public function createLotTender()
    {
        return $this->createLotTenderInteractor->execute();
    }
}

