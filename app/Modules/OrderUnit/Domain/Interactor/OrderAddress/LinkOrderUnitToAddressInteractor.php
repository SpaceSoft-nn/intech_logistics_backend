<?php

namespace App\Modules\OrderUnit\Domain\Interactor\OrderAddress;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\InteractorModules\AddressOrder\Domain\Actions\LinkOrderToAddressAction;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\MainAddress\MainAddressVectorVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\Mylog;

class LinkOrderUnitToAddressInteractor
{

    public static function execute(OrderUnit $order, OrderUnitAddressDTO $dto) : bool
    {
        return (new self())->run($order, $dto);
    }

    private function run(OrderUnit $order, OrderUnitAddressDTO $dto) : bool
    {
       return $this->linkOrderToAddress($order, $dto);
    }

    private function linkOrderToAddress(OrderUnit $order, OrderUnitAddressDTO $dto) : bool
    {

        $status = false;

        /**
        * @var MainAddressVectorVO
        */
        $dtoMainVector = $dto->mainAddressVectorVO;

        /**
        * @var array
        */
        $addressArray = $dto->addressArray;

        #TODO Проблема множества запросов (изменить логику)
        {
            //получаем связку главного вектора движение
            $address_start_main = $this->getAddress($dtoMainVector->start_address_id);
            $address_end_main = $this->getAddress($dtoMainVector->end_address_id);
        }

        {
            //Начало главного адресс
            $status = LinkOrderToAddressAction::run(
                OrderToAddressDTO::make(
                    address: $address_start_main,
                    order: $order,
                    type_status: TypeStateAddressEnum::sending,
                    date: $dtoMainVector->start_date_delivery,
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
                    date: $dtoMainVector->end_date_delivery,
                    priority: 1,
                ),
            );
        }

        {
            /**
            * @var ?array
            */
            $addressArray = $dto->addressArray;
            if(!empty($addressArray)) {

                //Flag приоритености, делаем его 2, т.к 1 - будет главным адрессом движения.
                $flag = 2;

                foreach ($addressArray as $subArray) {

                    if( !empty($subArray) ) {

                        $address = $this->getAddress($subArray['id']);

                        $status = LinkOrderToAddressAction::run(
                            OrderToAddressDTO::make(
                                address: $address,
                                order: $order,
                                type_status: TypeStateAddressEnum::stringByCaseToObject($subArray['type']),
                                date: $subArray['date'] ?? null,
                                priority: $flag++, //постфиксный инкримент
                            ),
                        );

                    }


                }

            }
        }


        return $status;
    }

    private function getAddress(?string $address_id) : ?Address
    {

        try {

            $address = Address::findOrFail($address_id);

        } catch (ModelNotFoundException $th) {
            Mylog("Ошибка в получении Адресса {$address_id}");
            throw new ModelNotFoundException("Адресс: {$address_id} не найден.", 404);
        }

        return $address;
    }

}
