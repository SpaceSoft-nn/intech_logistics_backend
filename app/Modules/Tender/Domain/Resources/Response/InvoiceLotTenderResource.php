<?php

namespace App\Modules\Tender\Domain\Resources\Response;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InvoiceLotTenderResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            "id" => $this->id,
            "lot_tender_response_id" => $this->lot_tender_response_id,
            "price_for_km" => $this->price_for_km,
            "comment" => $this->comment,
            'transport' => $this->transport,
            // 'created_at' => Carbon::createFromFormat('Y-m-d', $this->created_at)->format('d.m.Y'),
            'created_at' => $this->created_at->format('d.m.Y'),

        ];
    }
}
