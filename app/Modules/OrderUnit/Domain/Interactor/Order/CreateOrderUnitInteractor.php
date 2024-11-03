<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Order;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\InteractorModules\AddressOrder\Domain\Actions\LinkOrderToAddressAction;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
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

        try {

            #TODO Нужно использовать паттерн цепочка обязаностей (handler)
            $order = DB::transaction(function($pdo) use($dto)  {

                /**
                * @var OrderUnit
                */
                $order = $this->createOrderUnit($dto);
                $this->linkOrderToAddress($order, $dto);

                return $order;
            });

        } catch (\Throwable $th) {

            throw new Exception('Ошибка в CreateOrderUnitInteractor', 500);

        }

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
            type_load_truck: $dto->type_load_truck,
            end_date_order: $dto->end_date_order,
            product_type: $dto->product_type,
            order_status: $dto->order_status,
            user_id: $dto->user_id,
            contractors_id: $dto->contractors_id,

            //bool значения
            add_load_space: $this->filterIsLtlType($dto->type_load_truck),
            change_price: false,
            change_time: false,
            address_is_array: $this->filterIsArrayAddress($dto->address_array),

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

        $status = false;

        #TODO Проблема ножества запросов (изменить логику)
        {
            //получаем связку главного вектора движение
            $address_start_main = $this->getAddress($dto->start_address_id);
            $address_end_main = $this->getAddress($dto->end_address_id);
        }

        {
            //Начало главного адресс
            $status = LinkOrderToAddressAction::run(
                OrderToAddressDTO::make(
                    address: $address_start_main,
                    order: $order,
                    type_status: TypeStateAddressEnum::sending,
                    date: $dto->start_date_delivery,
                    priority: 1,
                ),
            );
        }

        {
            //Конец главного адресса
            $status = LinkOrderToAddressAction::run(
                OrderToAddressDTO::make(
                    address: $address_end_main,
                    order: $order,
                    type_status: TypeStateAddressEnum::coming,
                    date: $dto->end_date_delivery,
                    priority: 1,
                ),
            );
        }

        {

            if(!empty($dto->Address_array)) {

                $flag = 2;

                foreach ($dto->address_array as $subArray) {

                    if( !empty($subArray) ) {

                        //Flag приоритености, делаем его 2, т.к 1 - будет главным адрессом движения.
                        foreach ($subArray as $uuid => $date) {

                            $address = $this->getAddress($uuid);

                            $status = LinkOrderToAddressAction::run(
                                OrderToAddressDTO::make(
                                    address: $address,
                                    order: $order,
                                    type_status: TypeStateAddressEnum::coming, #TODO - Нужно потом указывать не стандартное (в массиве получать адресс прибытия это или отбытия в валидации)
                                    date: $date,
                                    priority: $flag++,
                                ),
                            );

                        }

                    }

                }

            }
        }


        return $status;
    }

    private function getAddress(string $Address_id) : ?Address
    {

        try {

            return Address::findOrFail($Address_id);

        } catch (\Throwable $th) {

            throw new Exception("Адресс: {$Address_id} не найден.", 404);

        }

    }

    /**
     * Проверяем, пустой ли массив адрессов
     * @param ?array $arrAddress
     *
     * @return bool
     */
    private function filterIsArrayAddress(?array $arrAddress = null) : bool
    {
        return empty($arrAddress) ? false : true;
    }

    /**
     * Проверяем, пустой ли массив адрессов
     * @param ?array $arrAddress
     *
     * @return bool
    */
    private function filterIsLtlType(string $type_load_truck) : bool
    {

        return TypeLoadingTruckMethod::ltl === TypeLoadingTruckMethod::stringByCaseToObject($type_load_truck);
    }

}
