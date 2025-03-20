<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoceOrderResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "transport_id" => $this->transport,
            "price" => $this->price,
            "date" => $this->date,
            "comment" => $this->comment,
            'created_at' => $this->created_at->format('d.m.Y'),

        ];
    }
}
