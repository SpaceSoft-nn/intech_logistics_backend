<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Actions\OrganizationOrderUnitInvoice;


use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use Exception;

class OrganizationOrderUnitInvoiceCreateAction
{

    /**
     * @param string $orderId
     * @param string $orgId
     * @param string $invoiceId
     *
     * @return ?OrganizationOrderUnitInvoice
     */
    public static function make(
        string $orderId, string $orgId, string $invoiceId
    ) : ?OrganizationOrderUnitInvoice {

        return self::run(
            orderId: $orderId,
            orgId: $orgId,
            invoiceId: $invoiceId,
        );

    }

    /**
     * @param string $orderId
     * @param string $orgId
     * @param string $invoiceId
     *
     * @return ?OrganizationOrderUnitInvoice
     */
    public static function run(string $orderId, string $orgId, string $invoiceId) : ?OrganizationOrderUnitInvoice
    {


        try {

            $model = OrganizationOrderUnitInvoice::create([
                'order_unit_id' => $orderId,
                'organization_id' => $orgId,
                'invoice_order_id' => $invoiceId,
            ]);

        } catch (\Throwable $th) {

            throw new Exception('Ошибка создание OrganizationOrderUnitInvoiceCreateAction', 500);

        }

        return $model ? $model : null;
    }
}
