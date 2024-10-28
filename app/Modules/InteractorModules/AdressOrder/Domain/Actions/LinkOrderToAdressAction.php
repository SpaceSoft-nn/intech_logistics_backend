<?php

namespace App\Modules\InteractorModules\AdressOrder\Domain\Actions;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\InteractorModules\AdressOrder\App\Data\DTO\OrderToAdressDTO;
use App\Modules\InteractorModules\AdressOrder\App\Data\Enum\TypeStateAdressEnum;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Exception;

class LinkOrderToAdressAction

{
    /**
     * Нам нужно сохранять связь многие ко многим таким способом (что бы laravel связи работали)
     * @param OrderToAdressDTO $user
     *
     * @return bool
     */
    public static function run(OrderToAdressDTO $dto) : bool
    {

        try {

            /**
            * @var Adress
            */
            $adress = $dto->adress;

            /**
            * @var OrderUnit
            */
            $order = $dto->order;

            /**
            * @var TypeStateAdressEnum
            */
            $type_status = $dto->type_status;

            $adress->order_units()->syncWithoutDetaching([$order->id => [
                'data_time' => $dto->date,
                'type' => $type_status,
                'priority' => $dto->priority,
            ]]);

            return true;

        } catch (\Throwable $th) {
            throw new Exception('Ошибка в связывании LinkOrderToAdressAction', 500);
        }

        return false;

    }
}
