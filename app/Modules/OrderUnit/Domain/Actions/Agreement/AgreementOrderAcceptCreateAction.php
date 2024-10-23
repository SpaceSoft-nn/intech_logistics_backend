<?php

namespace App\Modules\OrderUnit\Domain\Actions\Agreement;

use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use Exception;

class AgreementOrderAcceptCreateAction
{

    public function __construct(
        public string $agreement_order_id
    ) { }

    public static function make(string $agreement_order_id) : ?AgreementOrderAccept
    {
        return (new self($agreement_order_id))->run();
    }

    /**
     *
     * @return ?AgreementOrderAccept
     */
    private function run() : ?AgreementOrderAccept
    {

        try {

            $agreementOrderAcceptModel = AgreementOrderAccept::create([
                "agreement_order_id" => $this->agreement_order_id,
            ]);

        } catch (\Throwable $th) {

            throw new Exception('Ошибка в AgreementOrderAcceptCreateAction', 500);

        }

        return $agreementOrderAcceptModel;
    }
}
