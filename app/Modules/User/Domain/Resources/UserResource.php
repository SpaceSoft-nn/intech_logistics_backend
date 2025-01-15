<?php

namespace App\Modules\User\Domain\Resources;

use App\Modules\Organization\Domain\Resources\OrganizationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,

            'role' => $this->role,
            'auth' => $this->auth,

            'personal_area_id' => $this->personal_area_id,
            'email_id' => $this->email?->value ?? null,
            'phone_id' => $this->phone?->value ?? null ,
            'type_cabinet' => $this->organizations->map(function ($organization) {
                return [
                    'organization_id' => OrganizationResource::make($organization),
                    'type_cabinet' => $organization->pivot->type_cabinet,
                ];
            }),
        ];
    }
}
