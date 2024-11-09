<?php

namespace App\Modules\OrderUnit\Domain\Actions\CargoGood;

use App\Modules\OrderUnit\Domain\Models\CargoGood;
use Exception;

class CreateCargoGoodAction
{

    public function __construct(
        public string $agreement_order_id
    ) { }

    public static function make(string $agreement_order_id) : ?CargoGood
    {
        return (new self($agreement_order_id))->run();
    }

    /**
    *
    * @return ?CargoGood
    */
    private function run() : ?CargoGood
    {

        try {

            $agreementOrderAcceptModel = CargoGood::create([
                "agreement_order_id" => $this->agreement_order_id,
            ]);

        } catch (\Throwable $th) {

            throw new Exception('Ошибка в AgreementOrderAcceptCreateAction', 500);

        }

        return $agreementOrderAcceptModel;
    }
}
