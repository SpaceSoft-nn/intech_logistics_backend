<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Actions\OrganizationOrderUnitInvoice;

use App\Modules\Base\Error\BusinessException;
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

        $status = OrganizationOrderUnitInvoice::where('order_unit_id', $orderId)->where('organization_id', $orgId)->first();

        //Если $orgId - уже откликнулась на заказ $orderId, выкидываем ошибку.
        if($status) { throw new BusinessException('Данная организация уже откликнулась на этот заказ.'); }

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
