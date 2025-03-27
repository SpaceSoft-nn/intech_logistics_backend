<?php

namespace App\Modules\OfferContractor\Domain\Interactor;

use App\Modules\Base\Error\BusinessException;
use App\Modules\OfferContractor\App\Data\Enums\OfferContractorStatusEnum;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use DB;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OfferContractor\Domain\Models\InvoiceOrderCustomer;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\User\Domain\Models\User;

class AgreementOfferAcceptInteractor
{

    public function __construct(
        private OrderUnitService $orderService
    ) {}

    public function execute(User $user, AgreementOrderContractorAccept $agreementOrderContractorAccept) : object
    {
        /**
         * Оборачиваем всё в транзакцию, т.к если дейсвтие не выполнится, какое-либо нужно откатывать и выкидывать ошибку
         * @var object
        */
        $object = DB::transaction(function () use ($user, $agreementOrderContractorAccept) {

            if($agreementOrderContractorAccept->order_bool && $agreementOrderContractorAccept->contractor_bool) {
                return $this->response(true, 'Заявки уже были успешна подтверждены с двух сторон.', $agreementOrderContractorAccept);
            }

            $model = app(static::class)->run($user, $agreementOrderContractorAccept);

            $this->createOrderUnit($agreementOrderContractorAccept);

            return $model;

        });

        return $object;

    }

    private function run(User $user, AgreementOrderContractorAccept $agreementOrderContractorAccept) : object
    {

        /** @var AgreementOrderContractor */
        $agreementOrderContractor = $agreementOrderContractorAccept->agreement_order_contractor;

        /** @var OfferContractorCustomer */
        $offerContractorCustomer = $agreementOrderContractor->offer_contractor_invoice_order_customer;

        //проверяем что запрос был от заказчика
        {
            if(!empty($offerContractorCustomer)) {


                foreach ($user->organizations as $organization) {

                    if($offerContractorCustomer->organization_id == $organization->id)
                    {


                        $agreementOrderContractorAccept->order_bool = true;
                        $agreementOrderContractorAccept->save();


                        return $this->response(true, "Заказчик успешно согласовал выполнение предложения перевозчика.", $agreementOrderContractorAccept);
                    }
                }

            }


            #TODO Когда будет фнукицонал завязан на конкретном user
            // if(!empty($order->user_id))
            // {
            //     if($order->user_id == $user->id)
            //     {
            //         $agreementOrderAccept->order_bool = true;
            //         $agreementOrderAccept->save();

            //         return $this->response( true, "Заказчик успешно согласовал выполнение заказа.", $agreementOrderAccept);
            //     }
            // }

        }

        //проверяем что запрос был от подрядчика
        {


            if(!empty($agreementOrderContractor))
            {


                foreach ($user->organizations as $organizations) {


                    if($agreementOrderContractor->organization_contractor_id == $organizations->id)
                    {

                        $agreementOrderContractorAccept->contractor_bool = true;
                        $agreementOrderContractorAccept->save();

                        return $this->response(true, 'Перевозчик успешно согласовал выполнение своего предложения.', $agreementOrderContractorAccept);
                    }
                }
            }
        }

        return $this->response(false, 'У данного пользователя нет прав на согласования заказа.');

    }

    private function createOrderUnit(AgreementOrderContractorAccept $agreementOrderContractorAccept) : ?OrderUnit
    {

        /** @var AgreementOrderContractor */
        $agreementOrderContractor = $agreementOrderContractorAccept->agreement_order_contractor;

        if($agreementOrderContractorAccept->order_bool && $agreementOrderContractorAccept->contractor_bool)
        {

            //создаём заказ
            /** @var OfferContractorCustomer */
            $invoice_customer = $agreementOrderContractor->offer_contractor_invoice_order_customer;

            /** @var OfferContractor */
            $offerContractor = $invoice_customer->offer_contractor;


            {   //Формируем VO для OrderUnitCreateDTO - передаём invoice_customer как массив
                /** @var InvoiceOrderCustomer */
                $invoce_order = $invoice_customer->invoice_order_customer;

                /** @var OrderUnitVO */
                $orderUnitVO = OrderUnitVO::fromArrayInvoiceOrderCustomerToObject($invoce_order->toArray())
                    ->setOrderStatus(StatusOrderUnitEnum::in_work)
                    ->setTransportId($offerContractor->transport_id)
                    ->setOrganizationId($invoice_customer->organization_id)
                    ->setOfferContractorId($offerContractor->id)
                    ->setContractorId($agreementOrderContractor->organization_contractor_id);

                /** @var OrderUnitAddressDTO */
                $orderUnitAddressDTO = OrderUnitAddressDTO::fromArrayInvoiceOrderCustomerToObject($invoce_order->toArray());
            }

            /** @var CargoGoodVO[] */
            $cargoGoodVO = CargoGoodVO::fromArrayInvoiceOrderCustomerToObject($invoce_order->toArray());


            /** @var OrderUnitCreateDTO */
            $orderUnitCreateDTO = OrderUnitCreateDTO::make(
                orderUnitVO: $orderUnitVO,
                cargoGoodVO : $cargoGoodVO,
                orderUnitAddressDTO: $orderUnitAddressDTO, #TODO Нужно будет потом добавлять логику при множественных Адрессах
            );

            $order = $this->orderService->createOrderUnit($orderUnitCreateDTO);

            //устанавливаем значения что бы у предложения перевозчика, было понятно к какому заказу относится
            $agreementOrderContractor->order_unit_id = $order->id;
            $agreementOrderContractor->save();

            $offerContractor->status = OfferContractorStatusEnum::in_work;
            $offerContractor->save();


            return $order;
        }

        return null;
    }

    private function response(bool $status, string $message, ?AgreementOrderContractorAccept $agreementOrderContractorAccept = null) : Object
    {

        return (object) [
            'data' => $agreementOrderContractorAccept,
            'status' => $status,
            'message' => $message,
        ];
    }

}
