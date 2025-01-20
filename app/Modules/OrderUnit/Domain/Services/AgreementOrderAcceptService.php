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

        #TODO Вынести в триггер
        //проверяем если документы подписаны с двух сторон, то устанавливаем для AgreementOrder - подрядчика в свойства contractor_id
        $this->checkAcceptAgreement($agreementOrderAccept);

        return $object;
    }

    /**
     * #TODO т.к у нас есть случай one_agreement: bool, когда договор пришёл с внешнего айпи и нужно подтвердить только 1 запись (ПРЕДУСМОТРЕТЬ ЭТО)
     * #Эту логику нужно выносить как триггеры в бд
     * Проверяем что со стороны заказчика и подрядчика документы были подписаны, и устанавливает в AgreementOrder - подрядчика
     * @return bool
     */
    public function checkAcceptAgreement(AgreementOrderAccept $agreementOrderAccept)
    {
        $agreementOrderAccept = $agreementOrderAccept->refresh();

        if($agreementOrderAccept->order_bool && $agreementOrderAccept->contractor_bool)
        {
            $contractor_id = $agreementOrderAccept->agreement->order->contractor_id;

            /**
            * @var AgreementOrder
            */
            $agrementOrder = $agreementOrderAccept->agreement;

            $agrementOrder->organization_contractor_id = $contractor_id;

            $agrementOrder->save();

            return true;
        }

        return false;
    }

}
