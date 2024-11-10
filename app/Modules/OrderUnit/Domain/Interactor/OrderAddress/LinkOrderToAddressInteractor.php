<?php

namespace App\Modules\OrderUnit\Domain\Interactor\OrderAddress;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\InteractorModules\AddressOrder\Domain\Actions\LinkOrderToAddressAction;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Exception;

class LinkOrderToAddressInteractor
{

    public static function execute(OrderUnit $order) : ?OrderUnit
    {
        return (new self())->run($order);
    }

    private function run(OrderUnit $order) : ?OrderUnit
    {

        try {

            $this->linkOrderToAddress($order, $dto);

        } catch (\Throwable $th) {

            throw new Exception('Ошибка в LinkOrderToAddressInteractor', 500);

        }

        return $order;
    }

    private function linkOrderToAddress(OrderUnit $order, OrderUnitCreateDTO $dto)
    {

        $status = false;

        #TODO Проблема множества запросов (изменить логику)
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

            if(!empty($dto->address_array)) {

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

    private function getAddress(string $address_id) : ?Address
    {

        try {

            return Address::findOrFail($address_id);

        } catch (\Throwable $th) {

            throw new Exception("Адресс: {$address_id} не найден.", 404);

        }

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
