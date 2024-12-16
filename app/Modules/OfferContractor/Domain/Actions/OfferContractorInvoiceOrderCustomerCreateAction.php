<?php

namespace App\Modules\OfferContractor\Domain\Actions;

use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorCustomerVO;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorInvoiceOrderCustomerVO;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;
use Exception;

use function App\Helpers\Mylog;

class OfferContractorInvoiceOrderCustomerCreateAction
{
    public static function make(OfferContractorCustomerVO $vo) : OfferContractorCustomer
    {
        return (new self())->run($vo);
    }

    private function run(OfferContractorCustomerVO $vo) : OfferContractorCustomer
    {
        try {

            $offerContractorCustomer = OfferContractorCustomer::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            Mylog('Ошибка в OfferContractorInvoiceOrderCustomerCreateAction при создании записи: ' . $th);
            throw new Exception('Ошибка в OfferContractorInvoiceOrderCustomerCreateAction', 500);

        }

        return $offerContractorCustomer;
    }
}
