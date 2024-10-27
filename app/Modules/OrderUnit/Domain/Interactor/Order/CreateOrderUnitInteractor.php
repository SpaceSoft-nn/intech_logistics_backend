<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Agreement;

use App\Modules\InteractorModules\AdressOrder\App\Data\DTO\OrderToAdressDTO;
use App\Modules\InteractorModules\AdressOrder\Domain\Actions\LinkOrderToAdressAction;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitCreate;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;
use Exception;

class CreateOrderUnitInteractor
{

    public static function execute(OrderUnitVO $vo) : ?OrderUnit
    {
        return (new self())->run($vo);
    }

    public function run(OrderUnitVO $vo) : ?OrderUnit
    {

        $order = $this->createOrderUnit($vo);

        return ;
    }

    private function createOrderUnit(OrderUnitVO $vo) : ?OrderUnit
    {
        return OrderUnitCreate::make($vo);
    }

    private function linkOrderToAddress(?OrderUnit $order)
    {
        return LinkOrderToAdressAction::run(
            OrderToAdressDTO::make(
                adress: ,
                order: ,
                type_status: ,
                date: ,
            ),
        );
    }
}
