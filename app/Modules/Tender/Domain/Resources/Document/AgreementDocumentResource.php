<?php

namespace App\Modules\Tender\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotTenderResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            'id_agreement_document' => $this->id,
            'lot_tender_id' => $this->lot_tender_id,
            'path' => $this->path,

        ];
    }
}
