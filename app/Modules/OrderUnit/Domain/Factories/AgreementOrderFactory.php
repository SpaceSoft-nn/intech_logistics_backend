<?php

namespace App\Modules\OrderUnit\Domain\Factories;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgreementOrderFactory extends Factory
{
    protected $model = AgreementOrder::class;

    public function definition(): array
    {
        /**
        * @var OrganizationOrderUnitInvoice
        */
        $orgOrderUnitInvoice = OrganizationOrderUnitInvoice::factory()->create();

        /**
        * @var OrderUnit
        */
        $order = OrderUnit::find($orgOrderUnitInvoice->order_unit_id);
        $order->contractor_id = $orgOrderUnitInvoice->organization_id;
        $order->save();

        /**
        * @var AgreementOrderCreateDTO
        */
        $agreementOrder = AgreementOrderCreateDTO::make(
            order_unit_id: $orgOrderUnitInvoice->order_unit_id,
            organization_contractor_id: null,
            organization_order_units_invoce_id : $orgOrderUnitInvoice->id,
        );

        return $agreementOrder->toArrayNotNull();
    }

}
