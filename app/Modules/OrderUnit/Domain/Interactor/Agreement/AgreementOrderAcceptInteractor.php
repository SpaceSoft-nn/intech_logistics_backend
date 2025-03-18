<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Agreement;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Repositories\OrganizationOrderUnitInvoiceRepository;
use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Repositories\AgreementOrderRepository;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnitStatus;
use App\Modules\User\Domain\Models\User;
use DB;
use Exception;

use function App\Helpers\Mylog;

/**
 * Интерактор для работы бизнес-логики когда заказчик выбирает подрядчика
 */
final class AgreementOrderAcceptInteractor
{

    public function __construct(
        private AgreementOrderRepository $agreementOrderRep,
        private OrderUnitRepository $orderUnitRep,
        private OrganizationOrderUnitInvoiceRepository $organizationOrderUnitInvoiceRep,
        private OrderUnitRepository $orderUnitRepository,
    ) { }


    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return object
     */
    public function execute(User $user, AgreementOrderAccept $agreementOrderAccept) : object
    {

        $object = $this->run($user, $agreementOrderAccept);

        #TODO Вынести в триггер?
        //проверяем если документы подписаны с двух сторон, то устанавливаем для AgreementOrder - подрядчика в свойства contractor_id
        $this->checkAcceptAgreement($agreementOrderAccept);

        return $object;
    }

    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return object
     */
    public function run(User $user, AgreementOrderAccept $agreementOrderAccept) : object
    {

        try {

            $array = DB::transaction(function ($pdo)  use ($user, $agreementOrderAccept) {

                /**
                * @var OrderUnit
                */
                $order = $agreementOrderAccept->agreement->order;

                //проверяем что запрос был от заказчика
                {
                    if(!empty($order->organization_id)) {



                        foreach ($user->organizations as $organization) {

                            if($order->organization_id == $organization->id)
                            {

                                $agreementOrderAccept->order_bool = true;
                                $agreementOrderAccept->save();


                                return $this->response(true, "Заказчик успешно согласовал выполнение заказа.", $agreementOrderAccept);
                            }
                        }

                    }

                    if(!empty($order->user_id))
                    {
                        if($order->user_id == $user->id)
                        {
                            $agreementOrderAccept->order_bool = true;
                            $agreementOrderAccept->save();

                            return $this->response( true, "Заказчик успешно согласовал выполнение заказа.", $agreementOrderAccept);
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

                                return $this->response(true, 'Перевозчик успешно согласовал выполнение заказа.', $agreementOrderAccept);
                            }
                        }
                    }
                }


                return $this->response(false, 'У данного пользователя нет прав на согласования заказа.');

            });

        } catch (\Throwable $th) {
            Mylog('Ошибка в AgreementOrderInteractor в методе run(): ' . $th);
            throw new Exception('Ошибка в AgreementOrderInteractor', 500);
        }


        return $array;

    }

    private function response(bool $status, string $message, ?AgreementOrderAccept $agreementAccept = null) : Object
    {

        return (object) [
            'data' => $agreementAccept,
            'status' => $status,
            'message' => $message,
        ];
    }

    /**
     * #TODO т.к у нас есть случай one_agreement: bool, когда договор пришёл с внешнего айпи и нужно подтвердить только 1 запись (ПРЕДУСМОТРЕТЬ ЭТО)
     * #Эту логику нужно выносить как триггеры в бд
     * Проверяем что со стороны заказчика и подрядчика документы были подписаны, и устанавливает в AgreementOrder - подрядчика
     * @return bool
     */
    private function checkAcceptAgreement(AgreementOrderAccept $agreementOrderAccept)
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


            //устанавливаем заказ в статус 'в работе'
            /** @var OrderUnit */
            $order = $agrementOrder->order;

            //устанавливаем в status in_work после двух-стороннего соглашения
            $this->setStatusOrder(StatusOrderUnitEnum::in_work, $order->id);

            return true;
        }

        return false;
    }

    private function setStatusOrder(StatusOrderUnitEnum $status, string $orderId) : OrderUnitStatus
    {
        return $this->orderUnitRepository->setStatus($status, $orderId);
    }


}
