<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\Domain\Actions\CargoGood\CreateCargoGoodAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;

class CargoGoodService
{

    public function createCargoGood(CargoGoodVO $vo) : CargoGood
    {
        return CreateCargoGoodAction::make($vo);
    }
}
