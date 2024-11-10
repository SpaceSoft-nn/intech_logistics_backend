<?php

namespace App\Modules\OrderUnit\App\Data\DTO\OrderUnit;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;

use function App\Helpers\Mylog;

class OrderUnitCreateDTO
{

    /**
     * @param OrderUnitVO $orderUnitVO
     * @param ?CargoGoodVO[] $cargoGoodVO
     * @param MainAddressVectorVO $mainAddressVectorVO
    */
    public function __construct(

        OrderUnitVO $orderUnitVO,
        MainAddressVectorVO $mainAddressVectorVO,
        ?array $cargoGoodVO,

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
        MainAddressVectorVO $mainAddressVectorVO,
        ?array $cargoGoodVO = null,

    ) : self {

        return new self(
            orderUnitVO: $orderUnitVO,
            mainAddressVectorVO: $mainAddressVectorVO,
            cargoGoodVO: $cargoGoodVO,
        );

    }

}
