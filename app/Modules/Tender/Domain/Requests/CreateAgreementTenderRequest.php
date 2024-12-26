<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;


class CreateAgreementTenderRequest extends ApiRequest
{

    public function authorize(): bool
    {
        #TODO Нужно делать проверку что сюда откликнулась организация, которой принадлежит тендер
        return true;
    }

    public function rules(): array
    {

        return [

            //Организация создателя тендера
            'organization_tender_create_id' => ['required' , 'uuid', 'exists:organizations,id'], #TODO Брать потом из токена

        ];


    }

}
