<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\User\Domain\Models\User;

class AgreementOrderAcceptService
{
    /**
     * Подписать договор со стороны user (проверка что user принадлежит к бизнес-логики AgreementOrderAccept)
     * @param User $user
     * @param AgreementOrderAccept $agreementOrderAccept
     *
     * @return Object
     */
    public function acceptAgreement(User $user, AgreementOrderAccept $agreementOrderAccept) : Object
    {
        /**
        * @var OrderUnit
        */
        $order = $agreementOrderAccept->agreement->order;

        //проверяем что запрос был от заказчика
        {
            if(!empty($order->organization_id)) {

                foreach ($user->organizations as $organizations) {

                    if($order->organization_id == $organizations)
                    {
                        $agreementOrderAccept->order_bool = true;
                        $agreementOrderAccept->save();


                        return $this->response(true, "Заказчик успешно согласовал выполнение заказа.");
                    }
                }

            }

            if(!empty($order->user_id))
            {
                if($order->user_id == $user->id)
                {
                    $agreementOrderAccept->order_bool = true;
                    $agreementOrderAccept->save();

                    return $this->response(true, "Заказчик успешно согласовал выполнение заказа.");
                }
            }

        }

        //проверяем что запрос был от подрядчика
        {

            if(!empty($order->contractor_id))
            {

                foreach ($user->organizations as $organizations) {

                    if($order->contractor_id == $organizations->id)
                    {
                        $agreementOrderAccept->contractor_bool = true;
                        $agreementOrderAccept->save();

                        return $this->response(true, 'Подрядчик успешно согласовал выполнение заказа.');
                    }
                }
            }
        }

        return $this->response(false, 'У данного пользователя нет прав на согласования заказа.');
    }

    private function response(bool $status, string $message) : Object
    {
        return (object) [
            'status' => $status,
            'message' => $message,
        ];
    }


}
