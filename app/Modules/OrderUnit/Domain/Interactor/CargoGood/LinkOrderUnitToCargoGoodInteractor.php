<?php

namespace App\Modules\OrderUnit\Domain\Interactor\CargoGood;

use App\Modules\OrderUnit\App\Data\DTO\CargoUnitToCargoGood\CargoUnitToCargoGoodDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnitToCargoGood\OrderUnitToCargoGoodDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoUnitVO;
use App\Modules\OrderUnit\Domain\Actions\CargoUnit\CreateCargoUnitAction;
use App\Modules\OrderUnit\Domain\Actions\LinkCargoUnitToCargoGoodAction;
use App\Modules\OrderUnit\Domain\Actions\LinkOrderUnitToCargoGoodAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Services\CargoGoodService;
use App\Modules\OrderUnit\Domain\Services\MgxValidationService;
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

            //Отправляем каждый CargoGood на валидацию Mgx
            foreach ($cargoGoods as $cargoGood) {

                if(isset($cargoGood->mgx)) {

                    //создаём сервес валидации и указываем cargoGood
                    $serviceValidationMgx = new MgxValidationService($cargoGood);
                    //Запускаем сервес валидации
                    $serviceValidationMgx->runVlidationMgx();

                    //Получаем количество слоев для одного паллета.
                    $countLayers = $serviceValidationMgx->returnLayerCount();

                    {  //создание CargoUnit и привязка к CargoGood + учитывание слоев в паллете

                        for ( $i = 0; $i < $cargoGood->cargo_units_count; $i++) {

                            /**
                            * @var CargoUnit
                            */
                            $cargoUnit = $this->CreateCargoUnit(CargoUnitVO::make(
                                pallets_space: $cargoGood->type_pallet->value,
                                customer_pallets_space: false,
                            ));

                            for ( $j = 0; $j < $countLayers; $j++) {

                                $this->LinkCargoUnitToCargoGood(CargoUnitToCargoGoodDTO::make(
                                    cargoGood: $cargoGood,
                                    cargoUnit: $cargoUnit,
                                    factor: $serviceValidationMgx->factorFillingHeight(),
                                ));

                            }

                        }


                        dd($cargoGood->cargo_units);

                    }

                } else {



                }



            }



            return true;
        });

        return true;
    }

    /**
     * Линкуем CargoUnit и CargoGood
     * @param CargoUnitToCargoGoodDTO $dto
     *
     * @return bool
     */
    private function LinkCargoUnitToCargoGood(CargoUnitToCargoGoodDTO $dto) : bool
    {
        return LinkCargoUnitToCargoGoodAction::run($dto);
    }

    /**
    * Создаём CargoUnit
    * @param CargoUnitVO $vo
    *
    * @return CargoUnit
    */
    private function CreateCargoUnit(CargoUnitVO $vo) : CargoUnit
    {
        return CreateCargoUnitAction::make($vo);
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
