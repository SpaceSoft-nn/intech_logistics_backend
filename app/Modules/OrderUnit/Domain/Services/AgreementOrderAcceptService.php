<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\Domain\Interactor\Agreement\AgreementOrderAcceptInteractor;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\User\Domain\Models\User;

class AgreementOrderAcceptService
{


    public function __construct(
        private AgreementOrderAcceptInteractor $agreementOrderInteractor,
    ) { }

    /**
     * Подписать договор со стороны user (проверка что user принадлежит к бизнес-логики AgreementOrderAccept)
     * @param User $user
     * @param AgreementOrderAccept $agreementOrderAccept
     *
     * @return Object
     */
    public function acceptAgreement(User $user, AgreementOrderAccept $agreementOrderAccept) : Object
    {
        //Ответ придёт в массиве - описания
        $object = $this->agreementOrderInteractor->execute($user, $agreementOrderAccept);



        return $object;
    }

}
