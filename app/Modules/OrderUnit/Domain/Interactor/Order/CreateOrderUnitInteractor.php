<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Agreement;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\InteractorModules\AdressOrder\App\Data\DTO\OrderToAdressDTO;
use App\Modules\InteractorModules\AdressOrder\App\Data\Enum\TypeStateAdressEnum;
use App\Modules\InteractorModules\AdressOrder\Domain\Actions\LinkOrderToAdressAction;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitCreate;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitCreateAction;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;
use Exception;

class CreateOrderUnitInteractor
{

    public static function execute(OrderUnitCreateDTO $dto) : ?OrderUnit
    {
        return (new self())->run($dto);
    }

    private function run(OrderUnitCreateDTO $dto) : ?OrderUnit
    {

        $order = $this->createOrderUnit($dto);



        return $order;
    }

    /**
     * Создаём OrderUnitVO и заполняем bool поля вы зависимости от данных
     * @param OrderUnitCreateDTO $dto
     *
     * @return ?OrderUnitVO
     */
    private function createOrderUnitVO(OrderUnitCreateDTO $dto) : ?OrderUnitVO
    {


        /**
        * @var OrderUnitVO
        */
        $vo = OrderUnitVO::make(

            body_volume: $dto->body_volume,
            order_total: $dto->order_total,
            description: $dto->description,
            organization_id: $dto->organization_id,
            type_load_truck: $dto->type_load_truck->value,
            end_date_order: $dto->end_date_order,
            product_type: $dto->product_type,
            order_status: $dto->order_status,
            user_id: $dto->user_id,
            contractors_id: $dto->contractors_id,

            //bool значения
            add_load_space: $this->filterIsArrayAdress($dto->adress_array_id),
            change_price: null,
            change_time: null,
            adress_is_array: $this->filterIsArrayAdress($dto->adress_array_id),

        );

        return $vo;

    }

    private function createOrderUnit(OrderUnitCreateDTO $dto) : ?OrderUnit
    {
        /**
        * @var OrderUnitVO
        */
        $vo = $this->createOrderUnitVO($dto);

        return OrderUnitCreateAction::make($vo);
    }

    private function linkOrderToAddress(OrderUnit $order, OrderUnitCreateDTO $dto)
    {

        {
            //получаем связку главного вектора движение
            $adress_start_main = $this->getAdress($dto->start_adress_id);
            $adress_end_main = $this->getAdress($dto->end_adress_id);
        }

        {
            //Начало главного адресс
            LinkOrderToAdressAction::run(
                OrderToAdressDTO::make(
                    adress: $adress_start_main,
                    order: $order,
                    type_status: TypeStateAdressEnum::sending,
                    date: $dto->start_date_delivery,
                ),
            );
        }

        {
            //Конец главного адресса
            LinkOrderToAdressAction::run(
                OrderToAdressDTO::make(
                    adress: $adress_end_main,
                    order: $order,
                    type_status: TypeStateAdressEnum::coming,
                    date: $dto->end_date_delivery,
                ),
            );
        }



    }

    private function getAdress(string $adress_id) : ?Adress
    {

        try {

            return Adress::findOrFail($adress_id);

        } catch (\Throwable $th) {

            throw new Exception("Адресс: {$adress_id} не найден.", 404);

        }

    }

    /**
     * Проверяем, пустой ли массив адрессов
     * @param ?array $arrAdress
     *
     * @return bool
     */
    private function filterIsArrayAdress(?array $arrAdress = null) : bool
    {
        return empty($arrAdress) ? false : true;
    }

}
