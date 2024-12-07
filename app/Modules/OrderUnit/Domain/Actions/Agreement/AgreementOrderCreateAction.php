<?php

namespace App\Modules\OrderUnit\Domain\Actions\Agreement;

use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use Exception;

class AgreementOrderCreateAction
{
    public static function make(AgreementOrderCreateDTO $dto) : ?AgreementOrder
    {
        return self::run($dto);
    }

    /**
     * @param OrderUnitVO $vo
     *
     * @return ?OrderUnit
     */
    private static function run(AgreementOrderCreateDTO $dto) : ?AgreementOrder
    {


        try {

            $order = AgreementOrder::create($dto->toArrayNotNull());

        } catch (\Throwable $th) {
            throw new Exception('Ошибка в AgreementOrderCreateAction', 500);
        }

        return $order;
    }
}
