<?php

namespace App\Modules\Organization\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array
    {
        return [
            "owner_id" => $this->owner_id,
            "name" => $this->name,
            "address" => $this->address,
            "website" => $this->website,
            "description" => $this->description,
            "industry" => $this->industry,
            "founded_date" => $this->founded_date,
            "phone" => $this->phone,
            "email" => $this->email,
            "remuved" => $this->remuved,
            "type" => $this->type,
            "inn" => $this->inn,
            "kpp" => $this->kpp,
            "registration_number"=> $this->registration_number,
            "registration_number_individual" => $this->registration_number_individual,
        ];
    }
}
