<?php

namespace App\Modules\OfferContractor\Domain\Interactor;

use App\Modules\Base\Error\BusinessException;
use App\Modules\OfferContractor\App\Data\DTO\OfferContractorAgreementOfferDTO;
use App\Modules\OfferContractor\App\Data\Enums\OfferContractorStatusEnum;
use App\Modules\OfferContractor\App\Data\ValueObject\AgreementOrderContractorVO;
use App\Modules\OfferContractor\Domain\Actions\CreateAgreementOrderContractorAcceptAction;
use App\Modules\OfferContractor\Domain\Actions\CreateAgreementOrderContractorAction;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use App\Modules\OfferContractor\Domain\Models\InvoiceOrderCustomer;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitAddressDTO;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use DB;

class AgreementOfferContractorInteractor
{

    public static function execute(OfferContractorAgreementOfferDTO $dto) : AgreementOrderContractor
    {
        $orderService = app(OrderUnitService::class);
        return (new self())->run($dto, $orderService);
    }


    private function run(OfferContractorAgreementOfferDTO $dto, OrderUnitService $orderService) : AgreementOrderContractor
    {

        //валидимируем данные (выкидываем бизнес ошибки)
        $this->checkValidation($dto);

        /**
        * @var AgreementOrderContractor
        */
        $agreementOrderContractor = DB::transaction(function () use ($dto, $orderService) {

            /**
            * @var AgreementOrderContractor
            */
            $agreementOrderContractor = $this->createAgreementOrderContractor($dto);

            /**
            * @var AgreementOrderContractorAccept
            */
            $agreementOrderContractorAccept = $this->createAgreementOrderContractorAccept($agreementOrderContractor->id);



            //создаём заказ
            {
                /** @var OfferContractorCustomer */
                $invoice_customer = $agreementOrderContractor->offer_contractor_invoice_order_customer;


                {   //Формируем VO для OrderUnitCreateDTO - передаём invoice_customer как массив
                    /** @var InvoiceOrderCustomer */
                    $invoce_order = $invoice_customer->invoice_order_customer;

                    /** @var OrderUnitVO */
                    $orderUnitVO = OrderUnitVO::fromArrayInvoiceOrderCustomerToObject($invoce_order->toArray())
                        ->setOrganizationId($invoice_customer->organization_id)
                        ->setContractorId($agreementOrderContractor->organization_contractor_id);

                    /** @var orderUnitAddressDTO */
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

                $order = $orderService->createOrderUnit($orderUnitCreateDTO);

                //устанавливаем значения что бы у предложения перевозчика, было понятно к какому заказу относится
                $agreementOrderContractor->order_unit_id = $order->id;
                $agreementOrderContractor->save();
            }

            { // временно устанавливаем статус в работе

                /** @var OfferContractor */
                $offerContractor = $dto->offerContractor;

                $offerContractor->status = OfferContractorStatusEnum::in_work;

                $offerContractor->save();

            }


            return $agreementOrderContractor;

        });






        return $agreementOrderContractor;
    }

    private function createAgreementOrderContractor(OfferContractorAgreementOfferDTO $dto) : AgreementOrderContractor
    {


        //Создаём запись - когда перевозчик выбрал (орагинзацию заказчика) на предложения, пока согласование с двух сторон нету, то order_unit_id = null (заказ создавать после согласования)
        return CreateAgreementOrderContractorAction::make(
            AgreementOrderContractorVO::make(
                offer_contractor_invoice_order_customer_id: $dto->offer_contractor_customer_id,
                offer_contractor_id: $dto->offerContractor->id,
                order_unit_id: null,
                organization_contractor_id: $dto->offerContractor->organization_id,
                user_id: null,
            )
        );
    }

    private function createAgreementOrderContractorAccept(string $agreement_order_contractor_id) : AgreementOrderContractorAccept
    {
        return CreateAgreementOrderContractorAcceptAction::make($agreement_order_contractor_id);
    }

    private function checkValidation(OfferContractorAgreementOfferDTO $dto)
    {
        { // проверка на повторный отклик
            $status = AgreementOrderContractor::where('offer_contractor_invoice_order_customer_id', $dto->offer_contractor_customer_id)->first();

            if(!is_null($status))
            {
                throw new BusinessException('Организация заказчика, уже была выбрана на это предложения.', 422);
            }
        }

        { //проверка если на предложения уже откликнулись ранее
            /**
            * @var OfferContractor
            */
            $offerContractor = $dto->offerContractor;

            if(!is_null($offerContractor->agreement_order_contractor))
            {
                throw new BusinessException('Перевозчик для этого предложения, уже выбрал организацию - заказчика.', 422);
            }
        }
    }

}
