<?php

namespace App\Modules\OfferContractor\Domain\Actions;

use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OfferContractor\Domain\Models\InvoiceOrderCustomer;
use Exception;

use function App\Helpers\Mylog;

class InvoiceOrderCustomerCreateAction
{
    public static function make(InvoiceOrderCustomerVO $vo) : InvoiceOrderCustomer
    {
        return (new self())->run($vo);
    }

    private function run(InvoiceOrderCustomerVO $vo) : InvoiceOrderCustomer
    {

        try {

            $invoiceOrderCustomer = InvoiceOrderCustomer::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            Mylog('Ошибка в InvoiceOrderCustomerCreateAction при создании записи: ' . $th);
            throw new Exception('Ошибка в InvoiceOrderCustomerCreateAction', 500);

        }

        return $invoiceOrderCustomer;
    }
}
