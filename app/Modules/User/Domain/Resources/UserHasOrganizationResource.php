<?php

namespace App\Modules\User\Domain\Resources;

use Illuminate\Http\Request;

//возвращает всех user принадлежащих организации со статусом активации от Администратора
class UserHasOrganizationResource extends UserResource
{

    public function toArray(Request $request): array
    {
        //записываем значение в переменную
        $active = $this->active;

        //наследуем основной шаблон json resource order
        $data = parent::toArray($request);

        $data = array_merge($data, ['active' => $active]);

        return $data;
    }
}
