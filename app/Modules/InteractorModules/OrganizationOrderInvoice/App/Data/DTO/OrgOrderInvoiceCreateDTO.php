<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\DTO;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use Illuminate\Contracts\Support\Arrayable;

class OrgOrderInvoiceCreateDTO
{
    public function __construct(

        public readonly Organization $organization,
        public readonly OrderUnit $order,
        public readonly InvoiceOrderVO $invoiceOrderVO,

    ) { }

    public static function make(

        Organization $organization,
        OrderUnit $order,
        InvoiceOrderVO $invoiceOrderVO,

    ) : self {

        return new self(
            organization: $organization,
            order: $order,
            invoiceOrderVO: $invoiceOrderVO,
        );

    }


}
