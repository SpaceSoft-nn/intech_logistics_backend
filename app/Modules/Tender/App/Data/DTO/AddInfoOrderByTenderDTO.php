<?php

namespace App\Modules\Tender\App\Data\DTO;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use InvalidArgumentException;

use function App\Helpers\Mylog;


//DTO для дополнений важной инофрмации заказ при Тендере
final readonly class AddInfoOrderByTenderDTO
{
    /**
     * @param OrderUnit $orderUnit
     * @param OrderUnitAddressDTO $orderUnitAddressDTO
     * @param CargoGoodVO[] $cargoGoodVO
    */
    public function __construct(

        public OrderUnit $orderUnit,
        public OrderUnitAddressDTO $orderUnitAddressDTO,
        public array $cargoGoodVO,

    ) {

        if($cargoGoodVO){
            foreach ($cargoGoodVO as $cargo) {
                if (!$cargo instanceof CargoGoodVO) {
                    Mylog("Ошибка в AddInfoOrderByTenderDTO в переменной $cargoGoodVO, получен не правильный тип в массиве");
                    throw new InvalidArgumentException('Ошибка в AddInfoOrderByTenderDTO в переменной $cargoGoodVO', 500);
                }
            }
        }

    }

    public static function make(

        OrderUnit $orderUnit,
        OrderUnitAddressDTO $orderUnitAddressDTO,
        array $cargoGoodVO,

    ) : self {

        return new self(
            orderUnit: $orderUnit,
            orderUnitAddressDTO: $orderUnitAddressDTO,
            cargoGoodVO: $cargoGoodVO,
        );

    }

}
