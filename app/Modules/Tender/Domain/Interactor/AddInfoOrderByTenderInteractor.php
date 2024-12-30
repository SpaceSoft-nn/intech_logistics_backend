<?php

namespace App\Modules\Tender\Domain\Interactor;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Interactor\CargoGood\LinkOrderUnitToCargoGoodInteractor;
use App\Modules\OrderUnit\Domain\Interactor\OrderAddress\LinkOrderUnitToAddressInteractor;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\Tender\App\Data\DTO\AddInfoOrderByTenderDTO;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use DB;
use Illuminate\Support\Carbon;

// Обновление заказа - добавление важных значений для заказа
final class AddInfoOrderByTenderInteractor
{

    public function __construct(
        private LinkOrderUnitToAddressInteractor $orderToAddressInteractor,
        private LinkOrderUnitToCargoGoodInteractor $orderToCargoGoodInteractor,
    ) { }


    public function execute(AddInfoOrderByTenderDTO $dto) : OrderUnit
    {
        return $this->run($dto);
    }


    private function run(AddInfoOrderByTenderDTO $dto) : OrderUnit
    {
        /** @var OrderUnit */
        $order = DB::transaction(function () use ($dto) {

            $status = $this->linkAddressToOrder($dto);

            $orderUnit = $this->linkAndCreateCargoGoodToOrder($dto);

            return $orderUnit;
        });

        return $order;
    }

    //Логика привязки Адресс[a/ов] к заказу
    private function linkAddressToOrder(AddInfoOrderByTenderDTO $dto) : bool
    {
        return $this->orderToAddressInteractor->execute(
            order: $dto->orderUnit,
            dto: $dto->orderUnitAddressDTO,
        );
    }

    //Логика создание и привязок Cargo Good к заказу
    private function linkAndCreateCargoGoodToOrder(AddInfoOrderByTenderDTO $dto) : OrderUnit
    {
        return $this->orderToCargoGoodInteractor->execute(
            order: $dto->orderUnit,
            cargoGoodsVO: $dto->cargoGoodVO,
        );
    }

}
