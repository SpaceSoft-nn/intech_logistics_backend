<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Common\Tests\Feature;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationOrderInvoiceTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_factoty_invoiceOrder()
    {
        $model = InvoiceOrder::factory()->create();

        $this->assertNotNull($model);
    }

    /**
     * Тестирование factory OrganizationOrderUnitInvoice
     * P.S Не будет работать, нам нужны уже заполненные сидами OrderUnit (У которых есть связи с адрессами)
     * @return
     */
    public function test_create_factoty_OrganizationOrderUnitInvoice()
    {
        $model = OrganizationOrderUnitInvoice::factory()->create();

        $this->assertNotNull($model);
    }
}
