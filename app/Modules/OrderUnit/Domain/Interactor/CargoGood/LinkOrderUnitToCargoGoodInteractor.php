<?php

namespace App\Modules\OrderUnit\Domain\Interactor\CargoGood;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnitToCargoGood\OrderUnitToCargoGoodDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\Domain\Actions\LinkOrderUnitToCargoGoodAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Services\CargoGoodService;
use DB;
use Exception;

use function App\Helpers\Mylog;

final class LinkOrderUnitToCargoGoodInteractor
{

    public function __construct(
        private CargoGoodService $serviceCargoGood
    ) {}

    /**
     * @param OrderUnit $order
     * @param CargoGoodVO[] $cargoGoodsVO
     *
     * @return bool
     */
    public function execute(OrderUnit $order, array $cargoGoodsVO) : bool
    {
        return $this->run($order, $cargoGoodsVO);
    }

    /**
     * @param OrderUnit $order
     * @param CargoGoodVO[] $cargoGoodsVO
     *
     * @return bool
     */
    private function run(OrderUnit $order, array $cargoGoodsVO) : bool
    {


        #TODO Нужно использовать паттерн цепочка обязаностей (handler)
        $order = DB::transaction(function($pdo) use($order, $cargoGoodsVO)  {


            { //Создание CargoGood и привязка к OrderUnit

                /**
                * @var CargoGood[]
                */
                $cargoGoods = $this->createCargoGood($cargoGoodsVO);
                $this->linkOrderToCargoGood($order, $cargoGoods);
            }

            $this->serviceCargoGood->isTrueCalculateBodyVolumeGeneral($cargoGoods[0]);

            return true;
        });

        return true;
    }

    /**
     * @param CargoGood[] $cargoGoods
     *
     * @return bool
     */
    private function linkOrderToCargoGood(OrderUnit $order, array $cargoGoods) : bool
    {
        $status = false;

        foreach ($cargoGoods as $cargoGood) {

            $status = LinkOrderUnitToCargoGoodAction::run(
                OrderUnitToCargoGoodDTO::make(
                    cargoGood: $cargoGood,
                    orderUnit: $order,
                )
            );

        }

        if($status == false) {

            Mylog('Ошибка в привязки CargoGood к OrderUnit');
            throw new Exception('Ошибка в привязки LinkOrderUnitToCargoGoodInteractor в методе linkOrderToCargoGood', 500);

        }
        return $status;
    }

    /**
     * @param ?CargoGoodVO[] $cargoGoodsVO $cargoGoodsVO
     *
     * @return CargoGood[] $cargoGoodsVO
     */
    private function createCargoGood(array $cargoGoodsVO) : array
    {
        $array = [];

        if(!empty($cargoGoodsVO))
        {

            foreach ($cargoGoodsVO as $vo) {
                $array[] = $this->serviceCargoGood->createCargoGood($vo);
            }

        } else {

            Mylog('Ошибка в методе createCargoGood в LinkOrderUnitToCargoGoodInteractor - массив Cargo Good оказался пустым');
            throw new Exception('Ошибка в createCargoGood - массив оказался пустым', 500);

        }

        return $array;
    }

}
