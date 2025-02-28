<?php

namespace App\Modules\Auth\Domain\Resources\Phone;

use App\Modules\Organization\Domain\Resources\OrganizationResource;
use Illuminate\Http\Request;

//Ресурс возврата всех организаций у user по phone
class OrganizationLoginResource extends OrganizationResource
{
    public function toArray(Request $request): array
    {
        //записываем значение в переменную
        $user_role_for_organization = $this->user_role_for_organization;

        //наследуем основной шаблон json resource order
        $data = parent::toArray($request);

        $data = array_merge($data, ['user_role_for_organization' => $user_role_for_organization]);

        return $data;
    }
}

