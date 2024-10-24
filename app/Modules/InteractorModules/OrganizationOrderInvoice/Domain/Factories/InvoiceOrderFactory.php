<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Factories;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class InvoiceOrderFactory extends Factory
{
    protected $model = InvoiceOrder::class;

    public function definition(): array
    {
        /**
        * @var InvoiceOrderVO
        */
        $invoiceOrder = InvoiceOrderVO::make(
            price: $this->faker->numberBetween(30000, 250000),
            date: now(),
            comment: $this->faker->text(),
        );

        return $invoiceOrder->toArrayNotNull();
    }

}
