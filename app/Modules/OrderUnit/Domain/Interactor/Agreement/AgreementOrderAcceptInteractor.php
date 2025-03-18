<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Agreement;

use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Repositories\OrganizationOrderUnitInvoiceRepository;
use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\App\Repositories\AgreementOrderRepository;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
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
    ) { }


    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return object
     */
    public function execute(User $user, AgreementOrderAccept $agreementOrderAccept) : object
    {
        return $this->run($user, $agreementOrderAccept);
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

                                return $this->response(true, 'Перевозчик успешно согласовал выполнение заказа.');
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

    private function response(bool $status, string $message) : Object
    {
        return (object) [
            'status' => $status,
            'message' => $message,
        ];
    }


}
