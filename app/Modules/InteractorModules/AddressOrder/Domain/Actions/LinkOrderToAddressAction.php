<?php

namespace App\Modules\InteractorModules\AddressOrder\Domain\Actions;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\App\Data\DTO\OrderToAddressDTO;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Exception;

class LinkOrderToAddressAction

{
    /**
     * Нам нужно сохранять связь многие ко многим таким способом (что бы laravel связи работали)
     * @param OrderToAddressDTO $user
     *
     * @return bool
     */
    public static function run(OrderToAddressDTO $dto) : bool
    {

        try {

            /**
            * @var Address
            */
            $address = $dto->address;

            /**
            * @var OrderUnit
            */
            $order = $dto->order;

            /**
            * @var TypeStateAddressEnum
            */
            $type_status = $dto->type_status;

            $order->addresses()->syncWithoutDetaching([$address->id =>
                [
                    'data_time' => $dto->date,
                    'type' => $type_status,
                    'priority' => 1,
                ]
            ]);


            return true;

        } catch (\Throwable $th) {
            throw new Exception('Ошибка в связывании LinkOrderToAddressAction', 500);
        }

        return false;

    }
}
