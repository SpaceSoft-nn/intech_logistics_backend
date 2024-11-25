<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Actions\OrderInvoice;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use Exception;

use function App\Helpers\Mylog;

class InvoiceOrderCreateAction
{

    /**
     * @param InvoiceOrderVO $vo
     *
     * @return ?InvoiceOrder
     */
    public static function make(InvoiceOrderVO $vo) : ?InvoiceOrder
    {
        return self::run($vo);
    }

    /**
     * @param InvoiceOrderVO $vo
     *
     * @return ?InvoiceOrder
     */
    public static function run(InvoiceOrderVO $vo) : ?InvoiceOrder
    {

        try {

            $model = InvoiceOrder::create($vo->toArray());

        } catch (\Throwable $th) {
            Mylog('Ошибка создание OrderInvoice: ' . $th);
            throw new Exception('Ошибка создание OrderInvoice', 500);
        }

        return $model ? $model : null;
    }
}
