<?php

namespace App\Modules\OrderUnit\App\Data\DTO\OrderUnit;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use InvalidArgumentException;

use function App\Helpers\Mylog;

final readonly class OrderUnitCreateDTO
{

    /**
     * @param OrderUnitVO $orderUnitVO
     * @param OrderUnitAddressDTO $orderUnitAddressDTO
     * @param CargoGoodVO[] $cargoGoodVO
    */
    public function __construct(

        public OrderUnitVO $orderUnitVO,
        public OrderUnitAddressDTO $orderUnitAddressDTO,
        public array $cargoGoodVO,

    ) {

        foreach ($cargoGoodVO as $cargo) {
            if (!$cargo instanceof CargoGoodVO) {
                Mylog("Ошибка в OrderUnitCreateDTO в переменной $cargoGoodVO, получен не правильный тип в массиве");
                throw new InvalidArgumentException('Ошибка в OrderUnitCreateDTO в переменной $cargoGoodVO', 500);
            }
        }

    }

    public static function make(

        OrderUnitVO $orderUnitVO,
        OrderUnitAddressDTO $orderUnitAddressDTO,
        ?array $cargoGoodVO,

    ) : self {

        return new self(
            orderUnitVO: $orderUnitVO,
            orderUnitAddressDTO: $orderUnitAddressDTO,
            cargoGoodVO: $cargoGoodVO,
        );

    }

}
