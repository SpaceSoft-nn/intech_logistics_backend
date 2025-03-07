<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Factories;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class InvoiceOrderFactory extends Factory
{
    protected $model = InvoiceOrder::class;

    public function definition(): array
    {

        $transport = Transport::factory()->create();

        $date = Carbon::now()->format('d.m.Y');

        /**
        * @var InvoiceOrderVO
        */
        $invoiceOrder = InvoiceOrderVO::make(
            transport_id: $transport->id,
            price: $this->faker->numberBetween(30000, 250000),
            date: $date,
            comment: $this->faker->text(),
        );

        return $invoiceOrder->toArrayNotNull();
    }

}
