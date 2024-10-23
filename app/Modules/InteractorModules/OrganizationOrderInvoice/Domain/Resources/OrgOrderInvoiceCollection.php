<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources\OrgOrderInvoiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrgOrderInvoiceCollection extends ResourceCollection
{

    public $collects = OrgOrderInvoiceResource::class;

    public function toArray(Request $request): array
    {
        return [
            'collections' => $this->collection,
        ];
    }
}
