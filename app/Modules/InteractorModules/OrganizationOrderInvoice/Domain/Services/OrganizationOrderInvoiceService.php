<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Services;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\DTO\OrgOrderInvoiceCreateDTO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Interactor\InteractorOrgOrderInvoice;

class OrganizationOrderInvoiceService
{

    public function addСontractor(OrgOrderInvoiceCreateDTO $dto) : bool
    {
        return InteractorOrgOrderInvoice::run($dto);
    }

}
