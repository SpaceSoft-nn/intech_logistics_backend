<?php

namespace App\Modules\OrderUnit\Domain\Interactor\CargoGood;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;

use function App\Helpers\Mylog;

class LinkOrderUnitToCargoGoodInteractor
{

    /**
     * @param OrderUnit $order
     * @param ?CargoGoodVO[] $CargoGoodsVO
     *
     * @return bool
     */
    public function execute(OrderUnit $order, array $CargoGoodsVO) : bool
    {
        return $this->run($order, $dto);
    }

    private function run(OrderUnit $order, OrderUnitAddressDTO $dto) : bool
    {

    }

}
