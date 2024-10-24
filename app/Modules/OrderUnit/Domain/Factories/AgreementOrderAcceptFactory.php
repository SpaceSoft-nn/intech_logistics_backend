<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgreementOrderAcceptFactory extends Factory
{
    protected $model = AgreementOrderAccept::class;

    public function definition(): array
    {

        /**
        * @var AgreementOrder
        */
        $agreementOrder = AgreementOrder::factory()->create();

        return [
            "agreement_order_id" => $agreementOrder->id,
            "order_bool" => true,
            "contractor_bool" => true,
        ];
    }

}
