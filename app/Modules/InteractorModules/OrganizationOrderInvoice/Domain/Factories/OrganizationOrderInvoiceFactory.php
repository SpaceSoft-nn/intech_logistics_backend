<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Factories;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\DTO\OrgOrderInvoiceCreateDTO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Actions\LinkUserToPersonalAreaAction;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class OrganizationOrderInvoiceFactory extends Factory
{
    protected $model = OrganizationOrderUnitInvoice::class;


    public function definition(): array
    {
        /**
        * @var InvoiceOrder
        */
        $invoiceOrder = InvoiceOrder::factory()->create();

        /**
        * @var OrderUnit
        */
        $orderUnit = OrderUnit::inRandomOrder()->first();

        $organization = Organization::factory()->create();

        return [
            "order_unit_id" => $orderUnit->id,
            "organization_id" => $organization->id,
            "invoice_order_id" => $invoiceOrder->id,
        ];
    }

}
