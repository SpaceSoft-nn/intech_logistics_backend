<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Services;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\DTO\OrgOrderInvoiceCreateDTO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Interactor\InteractorOrgOrderInvoice;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;

class OrganizationOrderInvoiceService
{

    public function addСontractor(OrgOrderInvoiceCreateDTO $dto) : OrganizationOrderUnitInvoice
    {
        return InteractorOrgOrderInvoice::excexute($dto);
    }

}
